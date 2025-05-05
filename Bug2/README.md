# Instructions
Please complete the following tasks. You are welcome to use whatever methods you prefer. Aside from your changes in the code, please remember to provide a brief explanation in your email with the bug # you chose and how you went about troubleshooting it.

React relies on <a href="https://nodejs.org/en" target="_blank">Node.js</a> and npm for managing dependencies and running build scripts. Make sure you have both installed on your system. If you would prefer to use <a href="https://classic.yarnpkg.com/en/" target="_blank">Yarn</a>, you can use that instead.

Open a terminal and run the following command:

``` terminal
yarn install or npm install
yarn run watch or npm run watch
```

## Bug #2
You are given a small React app component that is supposed to fetch a list of users from a REST API and display their names in a list. However, the component is not working correctly.

```Javascript
import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

function UserList() {
  const [users, setUsers]: any = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchUsers();
  }, [users]);

  const fetchUsers = async () => {
    try {
      const response = await fetch('https://jsonplaceholder.typicode.com/users');
      const result = await response.json();
      setUsers(result);
    } catch (error) {
      console.error('Error fetching users:', error);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div>
      <h1>User List</h1>
      {loading ? (
        <p>Loading users...</p>
      ) : (
        <ul>
          {users.map((user: any) => (
            <li key={user.id}>{user.fullName}</li>
          ))}
        </ul>
      )}
    </div>
  );
}
```

<strong>Tasks:</strong>

1. Identify and fix the bugs in the component.

2. Ensure the user list displays correctly.

3. Improve the code structure if necessary.

<br>