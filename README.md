# Smart Italiano

## What the project is

Smart Italiano is a language pack for Italian. The pack holds lessons, a word bank, exercises and conversation prompts. Every part runs in Italian.

Portuguese, English and Russian stand behind the pack as reference languages. The learner checks an Italian word against any of the three. The pack carries the grammar, the sentence patterns and the audio.

The pack supplies no engine code of its own. The repository holds a small router and a front controller, and these answer the page route and the probe route.

## How to run it

Run every command from the repository root. The entry file in showroom/ reads `ITALIANO_BASE` to reach autoload.php, so export the variable first.

```
export ITALIANO_BASE=/italiano/
php -S 127.0.0.1:8119 -t showroom showroom/index.php
```

The runner in tests/ executes the suite.

```
php tests/run.php
```

## What the routes answer

The router holds the page route and the probe route.

The page route `/` answers with the HTML page. The front controller returns the HTML page for the pack.

The probe route `/status` answers with JSON. The JSON carries the fields `ok`, `lessons`, `words` and `references`. The `ok` field carries the probe result. The `lessons` field reports the lessons in the pack, the `words` field reports the word total, and the `references` field reports the reference languages.

## How the layout is arranged

- `autoload.php` loads the classes.
- `src/Home/` holds the model. `Lesson.php` holds one lesson. The lesson carries an id, a title, an order and words. Each word carries a gloss per reference language. `Pack.php` holds the lessons and groups them by order. The class totalises the words, lists the reference languages and counts the audio. `Sample.php` builds the pack.
- `src/App/` holds the router, the front controller and the HTML.
- `showroom/` holds the demo entry file and the stylesheet.
- `tests/` holds the hand-written runner, the assertion helper and the test file.
- `deploy/` holds the systemd unit and the nginx location block.

## The state of the suite

The suite runs 10 checks. The hand-written runner performs each check with the assertion helper. You start the suite with the command below.

```
php tests/run.php
```

## Licence

The repository uses the Mozilla Public License 2.0. The licence lets you use, change and share the code. The licence lets you combine the covered files with other code inside a larger work. The licence requires that modified covered files stay under the same terms when you share them.
