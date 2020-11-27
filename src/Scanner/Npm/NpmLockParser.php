<?php

declare(strict_types=1);

namespace Siketyan\Loxcan\Scanner\Npm;

use JsonException;
use Siketyan\Loxcan\Exception\ParseErrorException;
use Siketyan\Loxcan\Exception\UnsupportedVersionException;
use Siketyan\Loxcan\Model\Dependency;
use Siketyan\Loxcan\Model\DependencyCollection;
use Siketyan\Loxcan\Model\Package;
use Siketyan\Loxcan\Versioning\Version;

class NpmLockParser
{
    private const VERSION_PATTERNS = [
        '/^(\d+)\.(\d+)\.(\d+)(?:-[A-Za-z]+(?:\.(\d+))?)?$/',
    ];

    private NpmPackagePool $packagePool;

    public function __construct(
        NpmPackagePool $packagePool
    ) {
        $this->packagePool = $packagePool;
    }

    public function parse(?string $json): DependencyCollection
    {
        if ($json === null) {
            $json = '{}';
        }

        try {
            $assoc = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new ParseErrorException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious(),
            );
        }

        $packages = $assoc['packages'] ?? [];
        $dependencies = [];

        foreach ($packages as $name => $package) {
            $name = preg_replace('/^node_modules\//', '', $name);
            $version = $package['version'];
            $package = $this->packagePool->get($name);

            if ($name === '') {
                continue;
            }

            if ($package === null) {
                $package = new Package($name);
                $this->packagePool->add($package);
            }

            $dependencies[] = new Dependency(
                $package,
                $this->getVersion($version),
            );
        }

        return new DependencyCollection(
            $dependencies,
        );
    }

    private function getVersion(string $version): Version
    {
        foreach (self::VERSION_PATTERNS as $pattern) {
            if (preg_match($pattern, $version, $matches)) {
                return new Version(
                    (int) $matches[1],
                    (int) $matches[2],
                    (int) $matches[3],
                    count($matches) > 4 ? (int) $matches[4] : null,
                );
            }
        }

        throw new UnsupportedVersionException($version);
    }
}
