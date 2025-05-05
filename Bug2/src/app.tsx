import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

function UserList() {
  const [users, setUsers]: any = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchUsers();
  }, []); // BUG: infinite loop 
  // Avoid infinite loop by allow the lsit to update only when the component mounts

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
            <li key={user.id}>{user.name}</li>
            // BUG: API doenst have a "fullName" field
          ))}
        </ul>
      )}
    </div>
  );
}

const root = ReactDOM.createRoot(document.getElementById('wrapper') as HTMLElement);
root.render(
  <UserList />
);