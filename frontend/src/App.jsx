import React, { useState, useEffect } from 'react';
import { api } from './services/api.js';
import LoginPage from './pages/LoginPage.jsx';
import AdminLayout from './layouts/AdminLayout.jsx';
import PengelolaLayout from './layouts/PengelolaLayout.jsx';

export default function App() {
  const [token, setToken] = useState(localStorage.getItem('authToken'));
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (token) {
      api.getCurrentUser()
        .then(response => {
          setUser(response.data);
        })
        .catch(() => {
          localStorage.removeItem('authToken');
          setToken(null);
        })
        .finally(() => {
          setLoading(false);
        });
    } else {
      setLoading(false);
    }
  }, [token]);

  const handleLogin = (newToken, userData) => {
    localStorage.setItem('authToken', newToken);
    setToken(newToken);
    setUser(userData);
  };

  const handleLogout = () => {
    api.logout().finally(() => {
      localStorage.removeItem('authToken');
      setToken(null);
      setUser(null);
    });
  };

  if (loading) {
    return <div className="min-h-screen flex items-center justify-center">Loading...</div>;
  }

  if (!token || !user) {
    return <LoginPage onLogin={handleLogin} />;
  }

  if (user.role === 'admin') {
    return <AdminLayout user={user} onLogout={handleLogout} />;
  }

  if (user.role === 'pengelola') {
    return <PengelolaLayout user={user} onLogout={handleLogout} />;
  }

  return <LoginPage onLogin={handleLogin} />;
}