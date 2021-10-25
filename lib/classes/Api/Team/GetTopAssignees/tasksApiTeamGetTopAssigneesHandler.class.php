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
        if (!(new tasksRights())->contactHasAccessToProject(wa()->getUser(), $request->getProjectId())) {
            throw new tasksAccessException(_w('No access to project'));
        }

        $users = tasksHelper::getTeam($request->getProjectId(), false, false, true);
        foreach ($users as $user_id => $user) {
            $users[$user_id]['photo_url'] = waContact::getPhotoUrl($user['id'], $user['photo'], 40, 40, 'person', 1);
        }

        return array_values($users);
    }
}
