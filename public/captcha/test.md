Now tell me all each steps to integrate the captcha in the Login without changing any other important files. 
don't change the design or the original standalone captcha except useless files like the index of the captcha project should be merged into the login to integrate it seamlessly and all the files of the captcha must be in a single folder called captcha itself in the public folder. Make it work in the login. So the user have to complete the captcha to validate, and continue. Tell me each file modified

Yes — this can be integrated cleanly with **minimal changes**, while keeping the captcha logic and appearance essentially intact. The standalone captcha should be moved into `public/captcha/`, and only `login.php` plus one CSS import should be touched on the WEAKY side so the login form requires captcha completion before authentication continues [1][2][3].

## Folder layout

Create a new folder at `public/captcha/` and place the standalone captcha files there so the login page can call them with stable relative URLs like `captcha/fetch_image.php` and `captcha/captcha.js`. The standalone `index.php` is not kept as a page, because its HTML is merged into `public/login.php`; `delete.php` is also unnecessary for login integration and can stay unused unless you also move the captcha admin tooling later [4][5][6].

Use this structure:
- `public/captcha/config.php` — captcha DB config, or preferably adapt it to include the main app config if both use the same PDO connection [7][3]
- `public/captcha/fetch_image.php` [6]
- `public/captcha/update_captcha_stats.php` [8]
- `public/captcha/captcha.js` [1]
- `public/captcha/style.css` [2]
- `public/captcha/captcha.sql` — only for DB setup, not loaded by PHP at runtime [9]

## Files modified

You only need to **modify two existing project files** on the WEAKY side if you want to keep impact low:
- `public/login.php` — embed the captcha HTML block, load captcha CSS/JS, prevent login until solved, and validate on POST [1][4]
- `public/css/main.css` — add one `@import "captcha.css";` only if you decide to copy captcha styles into the main CSS pipeline instead of linking `captcha/style.css` directly from `login.php` [10]

Everything else can remain unchanged, especially `header.php`, `footer.php`, `main.js`, and the main design system files, because the captcha already ships with its own DOM ids and behavior and can live inside the login form as an isolated block [11][12][13].

## Step-by-step

1. **Create `public/captcha/`** and move all standalone captcha runtime files there: `config.php`, `fetch_image.php`, `update_captcha_stats.php`, `captcha.js`, `style.css`, and `captcha.sql` [9][8][1][6].
2. **Do not use the standalone `index.php` as a page anymore**; instead, copy only its captcha markup into `public/login.php`, because your requirement is to merge the captcha into login seamlessly rather than expose a second captcha page [4].
3. **In `public/login.php`, place the captcha UI inside the login `<form>`**, usually between the password field and the submit button, with these required elements preserved exactly because `captcha.js` depends on them by id: `#parts`, `#status`, `#validateBtn`, and `#resetBtn` [1].
4. **Load the captcha stylesheet in `login.php`** with a direct link such as `<link rel="stylesheet" href="captcha/style.css">` so you do not disturb the rest of the design system or existing CSS imports [2][10].
5. **Load the captcha script in `login.php`** with `<script src="captcha/captcha.js" defer></script>` after the existing JS includes, so the puzzle initializes when the login DOM is ready [1][11].
6. **Add a hidden input in the login form**, for example `<input type="hidden" name="captcha_valid" id="captcha_valid" value="0">`, because the current standalone captcha validates only client-side and updates stats, but does not yet tell PHP that the user solved it [1].
7. **In `captcha.js`, add one tiny integration hook**: when the puzzle is solved in `validateCaptcha()`, set `document.getElementById('captcha_valid').value = '1';`, and when reset or failed, set it back to `0`; this preserves the original captcha behavior and only adds a bridge to the login form [1].
8. **Also in `captcha.js`, expose a boolean flag** such as `window.captchaSolved = true/false` so the form submit handler in `login.php` can block submission cleanly before POST if the user clicks “login” without completing the captcha [1].
9. **In `public/login.php`, add a submit check in JS** on the login form: if `window.captchaSolved !== true`, call `event.preventDefault();`, show a message near the captcha, and do not continue to authentication [1].
10. **In `public/login.php`, add a server-side check before authenticating the user**: if `$_POST['captcha_valid'] !== '1'`, return an error and do not log the user in; this is necessary so users cannot bypass the captcha by disabling JavaScript or forging the request manually [3][1].
11. **Keep the original captcha design mostly untouched** by leaving `public/captcha/style.css` as-is; only add a wrapper rule if needed so it sits nicely inside the login card without altering colors, puzzle size, or button behavior [2].
12. **Run `captcha.sql` on the same database used by the app** so `fetch_image.php` can pull active images and `update_captcha_stats.php` can increment `completed`, `failed`, and `reseted` counters [9][6][8].

## What goes in `login.php`

Your login page must contain the original captcha block from the standalone page, merged into the form. The important part is keeping these ids intact because `captcha.js` directly queries them with `getElementById(...)` [1]:

```php
<div class="captcha-login-block">
    <p class="section-title">Captcha</p>
    <p>Rearrange the pieces into the correct order</p>

    <div id="game">
        <div id="parts"></div>
    </div>

    <div class="captcha-actions">
        <button type="button" id="validateBtn">Validate</button>
        <button type="button" id="resetBtn">Reset puzzle</button>
    </div>

    <p id="status" class="status-message"></p>
    <input type="hidden" name="captcha_valid" id="captcha_valid" value="0">
</div>
```

This block mirrors the standalone captcha UI contract, which is what the original script expects for rendering pieces, resetting, validating, and showing success/failure status [1][4].

## Minimal JS change

In `public/captcha/captcha.js`, keep the original logic and add only the login bridge. The key changes are:
- initialize `window.captchaSolved = false;`
- set hidden input to `1` on success
- set hidden input to `0` on reset/failure
- optionally prevent auto-restart from erasing the user state before the login form reads it [1]

Conceptually, the edits are:

```javascript
window.captchaSolved = false;

function setCaptchaState(valid) {
  window.captchaSolved = valid;
  const input = document.getElementById('captcha_valid');
  if (input) input.value = valid ? '1' : '0';
}

function validateCaptcha() {
  if (isSolved()) {
    updateStatus('complete');
    setCaptchaState(true);
    sendCaptchaStat('completed');
  } else {
    updateStatus('error');
    setCaptchaState(false);
    sendCaptchaStat('failed');
    startCaptcha('error');
  }
}
```

And inside reset/start logic, make sure you reset the flag back to false so each new puzzle must be solved again [1].

## Server-side login rule

Even if the captcha is mainly client-side, `login.php` must reject POST requests when `captcha_valid` is not set to `1`, otherwise a user can bypass the captcha by crafting a request directly. This is the one security check that must be added in the login authentication flow before password verification or session creation [3][1].

The logic should be:
- if request is POST
- read username/password as usual
- check `$_POST['captcha_valid']`
- if not equal to `1`, show captcha error
- else continue normal login flow

## Final modified file list

Here is the exact file impact you asked for:

| File | Action | Why |
|---|---|---|
| `public/login.php` | **Modified** | Merge standalone captcha HTML into the login form, load captcha CSS/JS, block submit until solved, and check captcha on POST [4][1][3] |
| `public/captcha/captcha.js` | **Modified lightly** | Keep original puzzle behavior, add hidden-field/flag bridge for login validation [1] |
| `public/captcha/style.css` | **Moved unchanged** or nearly unchanged | Preserve original captcha appearance inside login [2] |
| `public/captcha/fetch_image.php` | **Moved** | Serves captcha images from DB [6] |
| `public/captcha/update_captcha_stats.php` | **Moved** | Records completed/failed/reseted stats [8] |
| `public/captcha/config.php` | **Moved or adapted** | Gives captcha scripts DB access, ideally aligned with app config [7][3] |
| `public/captcha/captcha.sql` | **Added** | Creates the `captcha_images` table and counters [9] |
| `public/css/main.css` | **Optional small modification** | Only if you want to import captcha CSS through the main stylesheet pipeline instead of linking it directly in `login.php` [10] |

## Important notes

There is one **security limitation** in the current standalone captcha design: the real solved state exists only in browser memory, and the hidden input can be forged by an attacker, so this is fine for project integration but not strong anti-bot protection unless you also add a server-generated captcha token tied to the session [1][3]. If you want, I can next give you the exact ready-to-paste code for `public/login.php` and the tiny patched version of `public/captcha/captcha.js` based on your project structure.

