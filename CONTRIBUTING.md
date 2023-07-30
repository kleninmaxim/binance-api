# CONTRIBUTION GUIDELINES

Contributions are **welcome** and will be fully **credited**.

We accept contributions via pull requests on GitHub. Please review these guidelines before continuing.

## Guidelines

1) Please follow the [StyleCI](https://styleci.io/).
2) Ensure that the current tests pass, and if you've added something new, add the tests where relevant.
3) If you are changing or adding to the behaviour or public API, you may need to update the docs.
4) Please remember that we follow [Semantic Versioning](https://semver.org/).

## Running Tests

First, run StyleCI:

```bash
./vendor/bin/php-cs-fixer fix .
```

Second, run the tests:

```bash
phpunit
```
