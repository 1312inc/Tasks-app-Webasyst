<?php

final class tasksApiProjectAddRequest
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $icon;

    /**
     * @var string|null
     */
    private $icon_url;

    /**
     * @var string|null
     */
    private $color;

    /**
     * @var int|null
     */
    private $sort;

    /**
     * @var array|null
     */
    private $workflow;

    /**
     * tasksApiProjectAddRequest constructor.
     *
     * @param string                 $name
     * @param string|null            $icon
     * @param string|null            $color
     * @param string|null            $icon_url
     * @param int                    $sort
     * @param array|null             $workflow
     */
    public function __construct(
        string $name,
        ?string $icon,
        ?string $color,
        ?string $icon_url,
        int $sort,
        ?array $workflow
    ) {
        $this->name = $name;
        $this->icon = $icon;
        $this->color = $color;
        $this->sort = $sort;
        $this->icon_url = $icon_url;
        $this->workflow = $workflow;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function getIconUrl(): ?string
    {
        return $this->icon_url;
    }

    public function getWorkflow(): ?array
    {
        return $this->workflow;
    }
}
