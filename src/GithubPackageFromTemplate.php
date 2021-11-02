<?php

namespace DavidPeach\Manuscript;

use Github\Client;

class GithubPackageFromTemplate
{
    const GITHUB_WAIT_SECONDS = 3;

    private Client $api;

    private string $namespace;

    private string $repositoryName;

    private string $templateOwner;

    private string $templateRepository;

    public function __construct(string $token)
    {
        $this->api = new Client;
        $this->api->authenticate(tokenOrLogin: $token, password: null, authMethod: Client::AUTH_ACCESS_TOKEN);
    }

    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function setNewRepositoryName(string $repo): self
    {
        $this->repositoryName = $repo;

        return $this;
    }

    public function setTemplateOwner(string $templateOwner): self
    {
        $this->templateOwner = $templateOwner;

        return $this;
    }

    public function setTemplateRepository(string $templateRepository): self
    {
        $this->templateRepository = $templateRepository;

        return $this;
    }

    public function createRepository(): array
    {
        $repositoryData = $this->api->api(name: 'repo')->createFromTemplate(
            templateOwner: $this->templateOwner,
            templateRepo: $this->templateRepository,
            parameters: [
                'name' => $this->repositoryName,
                'owner' => $this->namespace,
            ]
        );

        sleep(seconds: self::GITHUB_WAIT_SECONDS);

        return $repositoryData;
    }

    public function validateToken(): void
    {
        $this->api->me()->show();
    }
}
