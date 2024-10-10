# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [4.0.4](https://github.com/ecphp/ecas/compare/4.0.3...4.0.4)

### Commits

- chore: maintenance, minor fixes [`5a409f9`](https://github.com/ecphp/ecas/commit/5a409f909d8969d4beb632d030a827a668dfee2f)

## [4.0.3](https://github.com/ecphp/ecas/compare/4.0.2...4.0.3) - 2024-10-08

### Commits

- chore: update changelog [`f4bdf06`](https://github.com/ecphp/ecas/commit/f4bdf064bce3ce9c67e2d41cf3f72697ede29af7)
- chore: autofix code style [`a89cd70`](https://github.com/ecphp/ecas/commit/a89cd70fa2a1b6388ae1f7053981c1946bb32453)
- chore: update default PHP version for development [`ed3a268`](https://github.com/ecphp/ecas/commit/ed3a2685a4f3a9fb9e856268dfe160402c7c4fa7)

## [4.0.2](https://github.com/ecphp/ecas/compare/4.0.1...4.0.2) - 2024-01-30

### Commits

- docs: update changelog [`92398d6`](https://github.com/ecphp/ecas/commit/92398d6d72bc886b2dac8f78fadd6a15d96080a9)
- chore: update license year [`1f7625e`](https://github.com/ecphp/ecas/commit/1f7625edc8330c1bd56de6e9fb2b98bcb3603a16)
- tests: add new tests [`9dc73ee`](https://github.com/ecphp/ecas/commit/9dc73ee9eeed870658d81053db181afd65ef8be4)
- fix: update precedence of parameters sent to ecphp/cas-lib [`c87e066`](https://github.com/ecphp/ecas/commit/c87e066bdfef6613ae337f1c824018a16b60dfe2)

## [4.0.1](https://github.com/ecphp/ecas/compare/4.0.0...4.0.1) - 2024-01-29

### Merged

- build(deps): bump actions/checkout from 3 to 4 [`#43`](https://github.com/ecphp/ecas/pull/43)
- build(deps): bump cachix/install-nix-action from 21 to 22 [`#41`](https://github.com/ecphp/ecas/pull/41)

### Commits

- docs: update changelog [`2783c9d`](https://github.com/ecphp/ecas/commit/2783c9d80a11348889ebaa13e53878286ff4e7b6)
- chore: autofix code style [`caea054`](https://github.com/ecphp/ecas/commit/caea054d3a897cc6edd5808ecb3fff0a11e81427)
- fix: use `pgtIou` and `pgtId` when sent using `POST` method [`3a803b0`](https://github.com/ecphp/ecas/commit/3a803b05b0fb835cd663b2911d6a9d0df3138032)

## [4.0.0](https://github.com/ecphp/ecas/compare/3.0.4...4.0.0) - 2023-05-30

### Merged

- feat: implements client fingerprint [`#38`](https://github.com/ecphp/ecas/pull/38)
- feat: implements login transactions [`#37`](https://github.com/ecphp/ecas/pull/37)

### Commits

- **Breaking change:** refactor: replace Properties::all() with `Properties::jsonSerialize()`. [`9517216`](https://github.com/ecphp/ecas/commit/95172168a9a6978c9a67e5f19b8cb6946652ebc4)
- docs: update CHANGELOG [`c650212`](https://github.com/ecphp/ecas/commit/c65021285343d565b95c4fa43d740226ad0e34d0)
- ci: bump versions [`0ce530b`](https://github.com/ecphp/ecas/commit/0ce530bd40137cd0020aedd89d98a6b8da77a170)
- chore: bump versions [`927101f`](https://github.com/ecphp/ecas/commit/927101fe261cbdba8e402b370eb9fe156f3d1a2f)
- chore: rename property [`4b78864`](https://github.com/ecphp/ecas/commit/4b78864bccaf525ef0adf8614c7ac378a69e84e4)
- autofix code style [`5385fd4`](https://github.com/ecphp/ecas/commit/5385fd496cfc287ed746ee768c319862fece2b1f)
- chore: rename property [`866ded5`](https://github.com/ecphp/ecas/commit/866ded5d580bae8f482569c414fefd4d4eac1277)
- refactor: update `composer.json` [`2215f3f`](https://github.com/ecphp/ecas/commit/2215f3fb608c8a802713c2231266fd2aae071d47)
- tests: cleanup [`2971fb2`](https://github.com/ecphp/ecas/commit/2971fb209063cc268b863a2206b5ebc77e672c41)
- tests: cleanup [`b301115`](https://github.com/ecphp/ecas/commit/b301115a388839c95198823eed729664cddf5737)
- doc: get rid of scrutinizer [`aa1caaf`](https://github.com/ecphp/ecas/commit/aa1caaf33fda8f9d09e57b52f6e81ec21d2ce376)
- ci: add steps to send static analysis statistics [`ec60aed`](https://github.com/ecphp/ecas/commit/ec60aedbeef02a87feedd93512c03105446ce358)
- fix: typo [`f3fddb4`](https://github.com/ecphp/ecas/commit/f3fddb4c245de3e35d1560d114a7e0e6f5db33c5)
- refactor: use `RequestHandler` objects [`5650990`](https://github.com/ecphp/ecas/commit/5650990338d5d76cb14dbfb47d3abefbc584bb66)
- refactor: use `RequestHandler` objects [`45be4dd`](https://github.com/ecphp/ecas/commit/45be4dd3813f5847574f2dbcd0f394565bfd44cd)
- cs: remove unused imports [`d48363c`](https://github.com/ecphp/ecas/commit/d48363c9cfb48e5776d5d3001c8d3679d109a426)

## [3.0.4](https://github.com/ecphp/ecas/compare/3.0.3...3.0.4) - 2023-04-12

### Commits

- docs: Update changelog. [`853808e`](https://github.com/ecphp/ecas/commit/853808e727350d0c300f1dfa598aca71c2bc8130)

## [3.0.3](https://github.com/ecphp/ecas/compare/3.0.2...3.0.3) - 2023-04-12

### Commits

- docs: Update changelog. [`4abf515`](https://github.com/ecphp/ecas/commit/4abf515ceb9e47580dd3e0901ef3dac664462530)
- Do not normalize anymore JSON responses [`e171f88`](https://github.com/ecphp/ecas/commit/e171f8841fa3a0be3117999adf4ea6b7e6b23ef0)

## [3.0.2](https://github.com/ecphp/ecas/compare/3.0.1...3.0.2) - 2023-04-12

### Merged

- build(deps): bump cachix/install-nix-action from 19 to 20 [`#36`](https://github.com/ecphp/ecas/pull/36)

### Commits

- docs: Update changelog. [`0afa56c`](https://github.com/ecphp/ecas/commit/0afa56c5916367fe0486ca543ca70376591e95c7)
- fix: array structure access [`d4ba614`](https://github.com/ecphp/ecas/commit/d4ba614fb67993590011c5495f03894dc8da16d7)

## [3.0.1](https://github.com/ecphp/ecas/compare/3.0.0...3.0.1) - 2023-02-07

### Merged

- build(deps): bump cachix/install-nix-action from 17 to 18 [`#35`](https://github.com/ecphp/ecas/pull/35)
- build(deps-dev): update monolog/monolog requirement from ^1.0 to ^1.0 || ^3.0 [`#34`](https://github.com/ecphp/ecas/pull/34)

### Commits

- docs: Update changelog. [`8810cb5`](https://github.com/ecphp/ecas/commit/8810cb562a46ca59a5cd601b5d4444186b71eb41)
- ci: add environment variable [`ff5c5dd`](https://github.com/ecphp/ecas/commit/ff5c5dd1f649c3e45fcbbc2bf9e656e9bee2572b)
- chore: update LICENSE file [`f82079e`](https://github.com/ecphp/ecas/commit/f82079e046955fcccc6d8da23a158eeb31e5d25d)
- style: autofix file style [`e20b6a7`](https://github.com/ecphp/ecas/commit/e20b6a739300cf842d0fdd1b291c4fe06eab9ed5)
- ci: update Github workflows syntax [`4fe701c`](https://github.com/ecphp/ecas/commit/4fe701c27af195360a9a537233a542a5e58ea671)
- refactor: switch from `XML` to `JSON` [`dd803a0`](https://github.com/ecphp/ecas/commit/dd803a0cbce579963e1fe294463bf82616101386)
- chore: update default `nix` environment [`1f9e657`](https://github.com/ecphp/ecas/commit/1f9e657447c144b3de8589ba2f940a63e07efb9d)
- docs: fix README badge [`7cf9d57`](https://github.com/ecphp/ecas/commit/7cf9d5725387f36872c21c331bd0c6597fa38d02)
- chore: Prettify the codebase. [`77e9a39`](https://github.com/ecphp/ecas/commit/77e9a39c3117967b2521cef4a344594bbf39b469)
- chore: Prettify the codebase. [`2612df8`](https://github.com/ecphp/ecas/commit/2612df8c43d07588e73c79086ef756d2ff7f458f)
- chore: Add `prettier` checks and fixes. [`aaff1c7`](https://github.com/ecphp/ecas/commit/aaff1c72d720bb65560cf0c039112eab62018a5b)
- build(deps-dev): update monolog/monolog requirement || ^3.0 [`e5262a2`](https://github.com/ecphp/ecas/commit/e5262a24df3d1a8871e3fa9860ac3bb91be39918)

## [3.0.0](https://github.com/ecphp/ecas/compare/2.4.0...3.0.0) - 2022-08-25

### Merged

- Update friends-of-phpspec/phpspec-code-coverage requirement from ^4.3.2 to ^4.3.2 || ^6.0.0 [`#19`](https://github.com/ecphp/ecas/pull/19)
- build(deps-dev): update phpstan/phpstan-strict-rules requirement from ^0.12 to ^0.12 || ^1.0 [`#22`](https://github.com/ecphp/ecas/pull/22)
- build(deps): bump actions/cache from 3.0.1 to 3.0.4 [`#29`](https://github.com/ecphp/ecas/pull/29)

### Commits

- docs: Update changelog. [`34a90ff`](https://github.com/ecphp/ecas/commit/34a90ff7d0fb75b1a05062be01ab7a13ecca3e3f)
- chore: Update `composer.json`. [`47a1c52`](https://github.com/ecphp/ecas/commit/47a1c5272c2ed4193c8d59c97cf6b8290fdfc036)
- chore: Update static files. [`d19f3ca`](https://github.com/ecphp/ecas/commit/d19f3ca4b1b746cb59e630017508dbb2875e23a4)
- chore: Update Infection configuration. [`9b4f0e3`](https://github.com/ecphp/ecas/commit/9b4f0e3e5e1627a140d597ee5a58eb4d0da4c438)
- fix: Autofix code style. [`7835c28`](https://github.com/ecphp/ecas/commit/7835c28295b17c2fc17580068f8fb096aff5c8b0)
- chore: Update `composer.json`. [`f20b319`](https://github.com/ecphp/ecas/commit/f20b3193ff50e2bd303e675503e3c7cf5c0cd0a7)
- chore: Set `cas-lib` version to `dev-master`. [`b17e946`](https://github.com/ecphp/ecas/commit/b17e946a19e832a411caaddb9025dbec487870b0)
- chore: Bump `cas-lib` version. [`862b746`](https://github.com/ecphp/ecas/commit/862b74628cb8d5851e9814e0c44176ea40ddba9a)
- chore: Fix dev dependencies version. [`a680658`](https://github.com/ecphp/ecas/commit/a68065830ebd4c20d181ab29c56a6d871e0f4c6b)
- ci: Update Github Action configuration. [`dea679e`](https://github.com/ecphp/ecas/commit/dea679ec8139d3314753ac193e3f46f88413c93e)
- fix: Update Scrutinizer configuration. [`91f735d`](https://github.com/ecphp/ecas/commit/91f735d672265bcbca53a2f27ca9227e42874992)
- chore: Remove Docker stuff. [`a07f929`](https://github.com/ecphp/ecas/commit/a07f92983d1bbecd490eb1a65262a79348c0d740)
- refactor: Upgrade codebase for `ecphp/cas-lib` upcoming version 2. [`eafd09e`](https://github.com/ecphp/ecas/commit/eafd09ec9194d14be73e7eb6fcc3e2ccbe8712b3)
- tests: Update tests accordingly. [`ff5c98f`](https://github.com/ecphp/ecas/commit/ff5c98f76fdc02e3f605ea858c6f6ec9b1bab3dd)
- refactor: Upgrade codebase for `ecphp/cas-lib` upcoming version 2. [`f16dcff`](https://github.com/ecphp/ecas/commit/f16dcffe5a7430775baeac69c4514ef4ae6c37e0)
- chore: Update `composer.json`. [`b9e2152`](https://github.com/ecphp/ecas/commit/b9e2152551c8bcae1d93f7759603bc65407ed744)
- build(deps-dev): update phpstan/phpstan-strict-rules requirement || ^1.0 [`4ddcade`](https://github.com/ecphp/ecas/commit/4ddcade174a941e20043be4bb2343ace5f3f4df3)
- Update friends-of-phpspec/phpspec-code-coverage requirement || ^6.0.0 [`2525759`](https://github.com/ecphp/ecas/commit/2525759b5a1ec0d31633b555770b1c338989d0d2)

## [2.4.0](https://github.com/ecphp/ecas/compare/2.3.0...2.4.0) - 2022-12-15

### Commits

- docs: Update changelog. [`69f92b9`](https://github.com/ecphp/ecas/commit/69f92b90ceb4031301f52732634adea7ebd52216)
- fix: use `JSON` instead of `XML` by default [`949a868`](https://github.com/ecphp/ecas/commit/949a868c483aed805a01d88f14f5851ff23ebbbe)
- tests: convert `XML` in `JSON` [`8230fe9`](https://github.com/ecphp/ecas/commit/8230fe95ab9d50fb24583006a78f209c1f2ef31e)
- nix: upgrade `.envrc` [`2796955`](https://github.com/ecphp/ecas/commit/2796955331f7e5ee8a1c8bcb5835af74253050a3)

## [2.3.0](https://github.com/ecphp/ecas/compare/2.2.0...2.3.0) - 2022-08-29

### Commits

- docs: Update changelog. [`8d9ef9c`](https://github.com/ecphp/ecas/commit/8d9ef9cf87f1f7e556b5d18864fb43877d50ab66)
- chore: Prettify codebase. [`3a0513a`](https://github.com/ecphp/ecas/commit/3a0513ad25a4ff56470b19a13dfe95633ad715b3)
- refactor: Update codebase for PHP &gt;= 8.0.2. [`df1b6e8`](https://github.com/ecphp/ecas/commit/df1b6e86a298f7fff103cf079e63e82d9b75b900)
- ci: Add `prettier` workflow. [`dec94c6`](https://github.com/ecphp/ecas/commit/dec94c6f8e993a3460c6b3ac56d74f7ad3e47a4f)
- chore: Get rid of docker, use Nix. [`f46137d`](https://github.com/ecphp/ecas/commit/f46137da360405d727597b2ce9344f64a6796843)
- chore: Update `PSalm` configuration. [`40c0390`](https://github.com/ecphp/ecas/commit/40c03905ee775c389e645088a21f577a906fef64)

## [2.2.0](https://github.com/ecphp/ecas/compare/2.1.3...2.2.0) - 2022-08-25

### Merged

- Update friends-of-phpspec/phpspec-code-coverage requirement from ^4.3.2 to ^4.3.2 || ^6.0.0 [`#19`](https://github.com/ecphp/ecas/pull/19)
- build(deps-dev): update phpstan/phpstan-strict-rules requirement from ^0.12 to ^0.12 || ^1.0 [`#22`](https://github.com/ecphp/ecas/pull/22)
- build(deps): bump actions/cache from 3.0.1 to 3.0.4 [`#29`](https://github.com/ecphp/ecas/pull/29)
- build(deps): bump actions/cache from 2.1.7 to 3.0.1 [`#25`](https://github.com/ecphp/ecas/pull/25)
- build(deps): bump actions/cache from 2.1.6 to 2.1.7 [`#23`](https://github.com/ecphp/ecas/pull/23)

### Commits

- docs: Update changelog. [`55bc0e2`](https://github.com/ecphp/ecas/commit/55bc0e2cd49c7977477a086ca7e919ca706567ae)
- chore: Update `.gitattributes`. [`3eb042b`](https://github.com/ecphp/ecas/commit/3eb042b021107efc9f9ea38b13e976589c2dcb1e)
- ci: Update workflows. [`1371f2a`](https://github.com/ecphp/ecas/commit/1371f2a55a943f9633d8b351912074cfc7a2902b)
- ci: Update workflows. [`5c20082`](https://github.com/ecphp/ecas/commit/5c200825255566ca82128a10cceb69681b7d8261)
- tests: Fix PHPSpec tests. [`35feeff`](https://github.com/ecphp/ecas/commit/35feeff5aaf0d9f38b18b71deacd2fcb8a44a96b)
- chore: Update psalm configuration. [`d36da82`](https://github.com/ecphp/ecas/commit/d36da823374932a097ede6a56bb23a02c96fdb13)
- chore: Drop older versions of PHP and Symfony. [`bdded01`](https://github.com/ecphp/ecas/commit/bdded018f2ff9537b800982fb04440805a9be6dc)
- chore: Fix dev dependencies version. [`a680658`](https://github.com/ecphp/ecas/commit/a68065830ebd4c20d181ab29c56a6d871e0f4c6b)
- ci: Update Github Action configuration. [`dea679e`](https://github.com/ecphp/ecas/commit/dea679ec8139d3314753ac193e3f46f88413c93e)
- fix: Update Scrutinizer configuration. [`91f735d`](https://github.com/ecphp/ecas/commit/91f735d672265bcbca53a2f27ca9227e42874992)
- chore: Remove Docker stuff. [`a07f929`](https://github.com/ecphp/ecas/commit/a07f92983d1bbecd490eb1a65262a79348c0d740)
- chore: Update licence holder. [`0266388`](https://github.com/ecphp/ecas/commit/0266388ef51ded16379a464c5087a533f264249f)
- chore: Normalize `composer.json`. [`d40c004`](https://github.com/ecphp/ecas/commit/d40c004672cd57687d5fcd9062beb143373a6f23)
- build(deps-dev): update phpstan/phpstan-strict-rules requirement || ^1.0 [`4ddcade`](https://github.com/ecphp/ecas/commit/4ddcade174a941e20043be4bb2343ace5f3f4df3)
- Update friends-of-phpspec/phpspec-code-coverage requirement || ^6.0.0 [`2525759`](https://github.com/ecphp/ecas/commit/2525759b5a1ec0d31633b555770b1c338989d0d2)

## [2.1.3](https://github.com/ecphp/ecas/compare/2.1.2...2.1.3) - 2021-10-13

### Merged

- Support different level of authentication through `authenticationLevel` config parameter [`#21`](https://github.com/ecphp/ecas/pull/21)

### Commits

- docs: Add/update CHANGELOG. [`4a0f228`](https://github.com/ecphp/ecas/commit/4a0f228e718062c62974905e44c344c200cb4d5e)
- refactor: Minor type/variable update. [`0b35851`](https://github.com/ecphp/ecas/commit/0b3585114f1a97df9622f2bf68809773187503b6)
- tests: Update tests accordingly. [`f14e71f`](https://github.com/ecphp/ecas/commit/f14e71f1b1f7798442eaa6d9963ee9fae28d7de8)
- refactor: Update based on ECAS documentation. [`a6b04c8`](https://github.com/ecphp/ecas/commit/a6b04c8a71725a6dbf10969260d40adea6feadc0)
- chore: Normalize composer.json. [`477bc9b`](https://github.com/ecphp/ecas/commit/477bc9b2f5e1f7eea1ca3dab82646c9c9b1e9541)
- tests: Update tests accordingly. [`2cf97df`](https://github.com/ecphp/ecas/commit/2cf97dfd6bb10f7cf8957ee637503497d02fad9b)
- feat: Support different types of `authenticationLevel`. [`19e7fbe`](https://github.com/ecphp/ecas/commit/19e7fbe94f590a0e240714cf08e9a7c1fbd7962c)

## [2.1.2](https://github.com/ecphp/ecas/compare/2.1.1...2.1.2) - 2021-08-19

### Merged

- Feature/add authentication level checks [`#20`](https://github.com/ecphp/ecas/pull/20)
- Update infection/infection requirement from ^0.13.6 || ^0.15.3 || ^0.23 to ^0.13.6 || ^0.15.3 || ^0.23 || ^0.24 [`#18`](https://github.com/ecphp/ecas/pull/18)
- Bump actions/cache from 2.1.5 to 2.1.6 [`#17`](https://github.com/ecphp/ecas/pull/17)

### Commits

- docs: Add/update CHANGELOG. [`31176b4`](https://github.com/ecphp/ecas/commit/31176b4f39dfaf45760aad53f94463c8de563492)
- chore: Update composer.json [`72a416f`](https://github.com/ecphp/ecas/commit/72a416fd2510f7532a028cb3fe0f60246415db35)
- refactor: Add checks on the authenticationLevel attribute. [`6096df8`](https://github.com/ecphp/ecas/commit/6096df827937c29aeff2cd5554bec59c93e7f6ce)
- tests: Add tests. [`278550d`](https://github.com/ecphp/ecas/commit/278550d05d8cb3e7885d83d11bbd48f342d3cb8a)
- ci: Enable builds only with PHP 7.4. [`f8ef545`](https://github.com/ecphp/ecas/commit/f8ef5451bb062ecf9bdee4789d7400a66c5481f1)
- Revert "ci: Disable builds on macOS until phpspec/phpspec#1380 is fixed." [`51ab96b`](https://github.com/ecphp/ecas/commit/51ab96b4847bab19bc07f54301fefd46b6b4cb05)

## [2.1.1](https://github.com/ecphp/ecas/compare/2.1.0...2.1.1) - 2021-07-05

### Merged

- Bump actions/cache from 2.1.4 to 2.1.5 [`#16`](https://github.com/ecphp/ecas/pull/16)
- Update vimeo/psalm requirement from ^3.12 to ^3.12 || ^4.0 [`#11`](https://github.com/ecphp/ecas/pull/11)
- Bump actions/cache from v2 to v2.1.4 [`#13`](https://github.com/ecphp/ecas/pull/13)

### Commits

- docs: Add/update CHANGELOG. [`a83a0ee`](https://github.com/ecphp/ecas/commit/a83a0eee4fd9fd83439f2410786bf0f8bab5c060)
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
