# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.1.1](https://github.com/ecphp/ecas/compare/2.1.0...2.1.1)

### Merged

- Bump actions/cache from 2.1.4 to 2.1.5 [`#16`](https://github.com/ecphp/ecas/pull/16)
- Update vimeo/psalm requirement from ^3.12 to ^3.12 || ^4.0 [`#11`](https://github.com/ecphp/ecas/pull/11)
- Bump actions/cache from v2 to v2.1.4 [`#13`](https://github.com/ecphp/ecas/pull/13)

### Commits

- Update License file. [`4dac434`](https://github.com/ecphp/ecas/commit/4dac434b61d2786f7e497d035cb219b933481bd1)
- Update Grumphp configuration. [`1fc901d`](https://github.com/ecphp/ecas/commit/1fc901d07144a236947f775061b6545eb1095e2f)
- ci: Add automated release on Github Action. [`19a3eeb`](https://github.com/ecphp/ecas/commit/19a3eebab28e8664ae6e8a86e1eb04b79e283388)
- ci: Disable builds on macOS until phpspec/phpspec#1380 is fixed. [`d528571`](https://github.com/ecphp/ecas/commit/d528571bf39aeb6e1cf6e887bf7c76c7ebef9216)
- Update Grumphp configuration. [`c218835`](https://github.com/ecphp/ecas/commit/c2188355949546e5afde5e7f80be441a0d6d3dd0)
- Autofix code style. [`b71711f`](https://github.com/ecphp/ecas/commit/b71711fc2d9828779c07eb2e519448e7a10e8ef7)
- Update composer.json. [`de963d0`](https://github.com/ecphp/ecas/commit/de963d022d94f131e0cd5e2b602c32370790e9d7)
- chore: Update static files. [`1cbb690`](https://github.com/ecphp/ecas/commit/1cbb6905bf5533682130cda2ba123484d32560a9)
- ci: Add docker stack for building CHANGELOG. [`4b3cfb9`](https://github.com/ecphp/ecas/commit/4b3cfb9a09b07640a70b81b0dac60770a4dfb726)
- Enable Psalm, Infection and Insights reports. [`c38a105`](https://github.com/ecphp/ecas/commit/c38a1051caa8c9f35a197325893ab3fb42c2e55d)

## [2.1.0](https://github.com/ecphp/ecas/compare/2.0.6...2.1.0) - 2020-07-23

### Merged

- New Instrospect internals and CasInterface::detect() method [`#9`](https://github.com/ecphp/ecas/pull/9)

### Commits

- Update composer.json. [`71fc5f0`](https://github.com/ecphp/ecas/commit/71fc5f046d3513728ebddfdd9643d20a2fac4906)
- Update the normalization function so it doesn't alter a valid response anymore. [`a54fe0e`](https://github.com/ecphp/ecas/commit/a54fe0e6a646e2856fce93887b87ad62f6ea0dfc)
- Add new CasInterface::detect() method. [`57641be`](https://github.com/ecphp/ecas/commit/57641bedeac74b70f6dd0f5ec9533e9576df6582)
- Add EcasIntrospector decorator to mangle the CAS response into a standard CAS response. [`eb6bf9c`](https://github.com/ecphp/ecas/commit/eb6bf9c5ae59e4ef385f40d83786e96fd41e3c31)

## [2.0.6](https://github.com/ecphp/ecas/compare/2.0.5...2.0.6) - 2020-07-23

### Commits

- Update Grumphp configuration. [`655c2b9`](https://github.com/ecphp/ecas/commit/655c2b98be13569a68a0782f846c83908f7959c3)

## [2.0.5](https://github.com/ecphp/ecas/compare/2.0.4...2.0.5) - 2020-07-23

### Commits

- Fix CS. [`7073bc7`](https://github.com/ecphp/ecas/commit/7073bc725c3e265e320b22dce016be1c3c6e4f2a)
- Update composer.json. [`6f4d87f`](https://github.com/ecphp/ecas/commit/6f4d87f1cb0d3b54611ee387b51a610418fa2de2)

## [2.0.4](https://github.com/ecphp/ecas/compare/2.0.3...2.0.4) - 2020-06-22

### Merged

- Refactor ticket extraction [`#8`](https://github.com/ecphp/ecas/pull/8)

## [2.0.3](https://github.com/ecphp/ecas/compare/2.0.2...2.0.3) - 2020-06-19

### Merged

- cas_ticket from authorization headers [`#7`](https://github.com/ecphp/ecas/pull/7)

## [2.0.2](https://github.com/ecphp/ecas/compare/2.0.1...2.0.2) - 2020-06-12

### Merged

- Align with  \CasLib\CasInterface.php [`#4`](https://github.com/ecphp/ecas/pull/4)
- Update nyholm/psr7-server requirement from ^0.4.1 to ^0.4.1 || ^1.0.0 [`#2`](https://github.com/ecphp/ecas/pull/2)
- Bump actions/cache from v1 to v2 [`#1`](https://github.com/ecphp/ecas/pull/1)

### Commits

- Add Dependabot configuration. [`9dd5074`](https://github.com/ecphp/ecas/commit/9dd5074fd022756ca1f6fff81a7eaf60571a68de)
- Revert "Update grumphp.yml.dist." [`9a999d3`](https://github.com/ecphp/ecas/commit/9a999d30fb51e3660dc052ecbcb3eabe7a465a1d)
- Add more tests. [`baa466b`](https://github.com/ecphp/ecas/commit/baa466bcbf14a9b9a66e2a6cfecf7599b8b88a0a)
- Add tests. [`8c45ba4`](https://github.com/ecphp/ecas/commit/8c45ba485e80ff2a2af901dd0713106e2f120550)
- Update grumphp.yml.dist. [`76e2c5a`](https://github.com/ecphp/ecas/commit/76e2c5a5aded3229e639eb7ad6d225ebe9532003)
- Remove obsolete PHPDoc comments. [`b3d4d41`](https://github.com/ecphp/ecas/commit/b3d4d41b8d6495eaa83cc06c90ebcf9aac1cbce2)

## [2.0.1](https://github.com/ecphp/ecas/compare/2.0.0...2.0.1) - 2020-06-09

### Commits

- Add forgotten file. [`0e92cdd`](https://github.com/ecphp/ecas/commit/0e92cdd04775d23ae0a18a60f3b57de8be0640e6)

## [2.0.0](https://github.com/ecphp/ecas/compare/1.0.1...2.0.0) - 2020-06-09

### Commits

- Use a better dependency injection mechanism by using the decorator pattern. [`a7ed841`](https://github.com/ecphp/ecas/commit/a7ed8417b8760520be2f81494da0f370573cb80c)
- Bump drupol/php-conventions. [`c5cd188`](https://github.com/ecphp/ecas/commit/c5cd188a819f470a6cbe2050e96a6370f6a1bdb6)

## [1.0.1](https://github.com/ecphp/ecas/compare/1.0.0...1.0.1) - 2020-05-07

### Commits

- Bump drupol/php-conventions. [`33262ec`](https://github.com/ecphp/ecas/commit/33262ecbeaaa64b6512e7753552397a9dd263362)
- Fix PHPStan warnings. [`13db733`](https://github.com/ecphp/ecas/commit/13db73360f8478097b7dfea6f6362f19313ff9a0)

## 1.0.0 - 2020-01-31

### Commits

- Migrate project to new organisation. [`e711543`](https://github.com/ecphp/ecas/commit/e711543eed9d8eae957a1ffc2700b2b6679586ee)
- Update PHPSpec configuration. [`8d5e98c`](https://github.com/ecphp/ecas/commit/8d5e98c099271a9d5eeb77582dd01abd13d3af4f)
- Update tests. [`18d0b12`](https://github.com/ecphp/ecas/commit/18d0b1254e3be0c9a23b9eca63bd53d205c13d20)
- Update composer.json file. [`22b326b`](https://github.com/ecphp/ecas/commit/22b326bfccf0bf7b2cc1ac43b486b4c048e21819)
- Update Github actions. [`6471167`](https://github.com/ecphp/ecas/commit/6471167b3b181d2239f4899678441c65012d5e44)
- Remove composer.lock. [`15e1155`](https://github.com/ecphp/ecas/commit/15e11555f1fb649c2238eaf020fd05c7f01d9809)
- Add tests. [`909464f`](https://github.com/ecphp/ecas/commit/909464f7f72c7170fa8fc9b4d4fb330b14ea0870)
- Initial commit. [`8ba4333`](https://github.com/ecphp/ecas/commit/8ba43335c83e7d4e5194b76ddd7c4ca044f352bb)
