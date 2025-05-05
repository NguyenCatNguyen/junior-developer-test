# 🐛 Debugging Report

## 🔍 Debugging Process

1. Ran the program and monitored the console for errors.
2. Followed the error messages to locate the file and specific line numbers causing the issues.
3. Analyzed the surrounding code to identify the root cause of each error.
4. Used GitHub Copilot to verify syntax and logic within the flagged sections.

---

## 🐞 Bug 1

### 📍 Location
- **File**: `index.php`
  - **Line 38**: Missing `{}` around `$data['name']`, causing output issues.
  - **Lines 29, 30, 35, 36**: Mixing `echo` and `return` caused unexpected behavior. The Slim framework expects a single return value; using both resulted in a `null` return.

### 💡 Thought Process
- For each case, I ran tests to confirm whether the error messages were properly displayed on the page.
- Although the error triggers were working, the app returned a fatal error not included in the custom error message.
- I used Copilot to identify the source of the fatal error and search for a solution.
- I discovered that mixing `echo` and `return` violated Slim’s expected response flow.
- I refactored the code and retested each case to ensure everything worked as expected.
- Additionally, I updated the error message text color to red for improved visibility to users.

### ✅ Other Considerations
- Added the `required` attribute to the `name` and `email` fields in the HTML form to enforce basic client-side validation. This enhances user experience and reduces unnecessary server requests due to incomplete form submissions.
- However, backend validation remains essential for security purposes.

---

## 🐞 Bug 2

### 📍 Location
- **File**: `index.html`
  - Incorrect script path: `src="js/app.js"` → should be `src="src/app.tsx"`
- **File**: `app.tsx`
  - **Line 10**: The dependency array should be empty to ensure the effect only runs on mount.
  - **Line 33**: Incorrect property name used for the user object; the referenced property does not exist in the API response.

### 💡 Thought Process
- I started by live testing the app in the browser and checking the console.
- By observing both the web page and the console, I noticed that the src path could not be found.
- I then inspected the index.html file and corrected the script path to src/app.tsx.
- After this fix, the web app loaded and displayed correctly, but the user names were empty.
- I manually followed the API endpoint in the browser to inspect the structure of the returned JSON
- I discovered a mismatch in the property name used in the code and the actual property name in the API response.

---

## 🐞 Bug 3

### 📍 Location
- **File**: `DiscussionBoard.php`
  - **Lines 86–87**: Mismatched quotation marks.
  - **Lines 24, 35, 46, 50, 62**: Improperly escaped `\\n` characters were printed as literal strings rather than rendering new lines.

### 💡 Thought Process
- I launched the live server. While there were no console errors, the page indicated an internal issue in the file.
- Upon reviewing `DiscussionBoard.php`, I noticed red underlines in VS Code highlighting syntax errors.
- I corrected the mismatched quotes and added the missing closing bracket.
- After restarting the live server, I confirmed that the issue was resolved.
- I also repositioned the error message to the bottom of the page for better visibility.