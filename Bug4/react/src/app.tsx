import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import JsonView from 'react18-json-view';
import 'react18-json-view/src/style.css';

const Feed = () => {
  const [posts, setPosts]: any = useState([]);

  useEffect(() => {
    // Fetch posts from backend
    fetch('http://localhost:5000/posts')
      .then(response => response.json())
      .then(data => {
        console.log(data);
        setPosts(data);
      });
  }, []);

  return (
    <div>
      <h1>Social Media Feed</h1>
      <>
        <JsonView src={posts} theme={'vscode'} collapsed={2} />
        {posts.map((post: any) => (
          <div key={post.post_id} className={'post'}>
            <div className={'post-header'}>
              <h3>{post.post_username}</h3>
              <span>{new Date(post.post_created_at).toLocaleString()}</span>
            </div>
            <p>{post.post_content}</p>
            {post.image_url && <img src={post.image_url} alt={'Post'} />}
            <div className={'comments'}>
              <h4>Comments:</h4>
              {post.comments.length === 0 ? (
                <p>No comments yet.</p>
              ) : (
                post.comments.map((comment: any) => (
                  <div key={comment.comment_id}>
                    <strong>{comment.comment_username}</strong>: {comment.comment_text}
                  </div>
                ))
              )}
            </div>
          </div>
        ))}
      </>
    </div>
  );
};

const root = ReactDOM.createRoot(document.getElementById('wrapper') as HTMLElement);
root.render(
  <Feed />
);
