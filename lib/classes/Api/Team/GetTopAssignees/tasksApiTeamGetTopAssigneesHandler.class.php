<?php

final class tasksApiTeamGetTopAssigneesHandler
{
    /**
     * @param tasksApiTeamGetTopAssigneesRequest $request
     *
     * @return array<array<string, mixed>>
     */
    public function getUsers(tasksApiTeamGetTopAssigneesRequest $request): array
    {
//        if (!(new tasksRights())->contactHasAccessToProject(wa()->getUser(), $request->getProjectId())) {
//            throw new tasksAccessException(_w('No access to project'));
//        }

        $users = tasksHelper::getTeam($request->getProjectId(), false, false, true);

        waLog::log('tasksHelper::getTeam', 'tasks/debuglog.log');
        waLog::dump(array_keys($users), 'tasks/debuglog.log');

        if ($request->getProjectId()) {
            $logs = tsks()->getModel('tasksTaskLog')
                ->getLastAssignedContactIdsForContactId(
                    array_keys($users),
                    $request->getProjectId(),
                    wa()->getUser()->getId()
                );

            waLog::log('$logs', 'tasks/debuglog.log');
            waLog::dump($logs, 'tasks/debuglog.log');

            $dataWithLogs = [];
            foreach ($logs as $log) {
                if (isset($users[$log['contact_id']])) {
                    $dataWithLogs[$log['contact_id']] = $users[$log['contact_id']];
                    $dataWithLogs[$log['contact_id']]['last_log_id'] = $log['id'];
                }
            }

            uasort(
                $dataWithLogs,
                static function ($a, $b) {
                    return -($a['last_log_id'] <=> $b['last_log_id']);
                }
            );

            waLog::dump('uasort $dataWithLogs', 'tasks/debuglog.log');
            waLog::dump(array_keys($dataWithLogs), 'tasks/debuglog.log');

            // sort with logs in beginning
            $sorted = $dataWithLogs + $users;

            waLog::dump('uasort $sorted', 'tasks/debuglog.log');
            waLog::dump(array_keys($sorted), 'tasks/debuglog.log');

            // move current user to 4 position
            $userId = wa()->getUser()->getId();

            $i = 0;
            $users = [];
            foreach ($sorted as $contactId => $datum) {
                $i++;
                if ($i < 4 && $userId == $contactId) {
                    continue;
                }
                $users[$contactId] = $datum;

                if ($i === 4) {
                    $users[$userId] = $sorted[$userId];
                    unset($sorted[$userId]);
                }
            }

            if ($i < 4) {
                $users[$userId] = $sorted[$userId];
            }

            waLog::dump('uasort $users', 'tasks/debuglog.log');
            waLog::dump(array_keys($users), 'tasks/debuglog.log');
        }

        foreach ($users as $user_id => $user) {
            $users[$user_id]['photo_url'] = waContact::getPhotoUrl($user['id'], $user['photo'], 96, 96, 'person', 1);
        }

        return array_values($users);
    }
}
