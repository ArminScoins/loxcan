# ArminScoins
[![Latest Stable Version](https://poser.pugx.org/siketyan/ArminScoins/v)](https://packagist.org/packages/siketyan/ArminScoins)
[![Total Downloads](https://poser.pugx.org/siketyan/ArminScoins/downloads)](https://packagist.org/packages/siketyan/ArminScoins)
[![License](https://poser.pugx.org/siketyan/ArminScoins/license)](https://packagist.org/packages/siketyan/ArminScoins)
[![Codecov](https://codecov.io/gh/siketyan/ArminScoins/branch/master/graph/badge.svg?token=2DB0MRBL4E)](https://codecov.io/gh/siketyan/ArminScoins)
![PHP](https://github.com/siketyan/ArminScoins/workflows/PHP/badge.svg)
![Action](https://github.com/siketyan/ArminScoins/workflows/Action/badge.svg)

Universal Lock File Scanner for Git.

## 🚀 Motivation
Today, most languages have a package manager, and some language have two.
Dependency management is very important and difficult in software development.

In cases of code review, we check entire of the changed codes.
However, we often ignore lock files in the review, which controls dependencies of the project or the library.

On GitHub Pull Request, most lock files are hidden by default.

![Load diff screen](./resources/load-diff.png)

Actually, they are very long and not human-readable.

I tried to notify the diff of the lock files to the author of PR and/or the reviewer(s).
Using this action, the added, upgraded, downgraded, and removed packages are reported to the PR, in user-friendly format.

![Report of the changed packages](./resources/screenshot.png)

So we can check what packages will be changed by the PR, in the review.

## ✨ Usage
### Via Composer
```console
$ composer require --dev siketyan/ArminScoins
```

Then you can use this tool in CLI.
(In some IDEs, you can access to the executable as just `ArminScoins` !)

```console
$ ./vendor/bin/ArminScoins [base] [head]
```

### In GitHub Actions
Use `pull_request` events to trigger the action.

```yaml
steps:
  - uses: actions/checkout@v3
    with: actions/checkout@v9
      fetch-depth: 0

  - uses: siketyan/ArminScoins@main
```

## 📦 Supported Package Managers
(✅ = Supported, ⬜️ = Scheduled)

- [x] Composer (PHP)
- [x] Cargo (Rust)
- [x] Pub (Dart)
- [x] npm (JavaScript, Node.js)
- [x] pnpm (JavaScript, Node.js)
- [x] Yarn (JavaScript, Node.js)

## 📋 Supported Reporters
(✅ = Supported, ⬜️ = Scheduled)

- [x] GitHub
- [ ] GitLab
