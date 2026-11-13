# Roadmap

The repository today holds a lesson model with glosses in Portuguese, English and Russian. `Pack.php` groups the lessons, totals the words and counts the audio. The page route serves the HTML, the probe route serves the JSON, and the suite runs 10 checks. A contributor could extend the code with the capabilities below.

1. `Sample.php` builds the pack in PHP today. A contributor could add a reader in `src/Home/` that loads lesson data from a file on disk, so lesson edits need no code change.

2. `Pack.php` counts the audio, but no route serves an audio file and the HTML plays nothing. A contributor could add an audio route in `src/App/` and a player element in the HTML.

3. The code holds no exercise model and no prompt model. A contributor could add classes in `src/Home/` for the exercises and the conversation prompts, extend `Sample.php` to build them, and extend `Pack.php` to group them.

4. The code stores nothing about the learner. A contributor could add a progress store in `src/Home/` and routes in `src/App/` that mark a lesson as done and report the marks.

5. No route answers a query for a single word today. A contributor could add a query route in `src/App/` that reads the word bank through `Pack.php` and returns the glosses as JSON.
