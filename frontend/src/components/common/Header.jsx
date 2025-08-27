import React from 'react';

const Header = ({ user, onLogout }) => (
  <header className="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0">
    <div>{/* Bisa diisi breadcrumbs atau judul halaman */}</div>
    <div className="flex items-center space-x-4">
      <span className="font-semibold">{user ? user.name : 'User'}</span>
      <button onClick={onLogout} className="text-indigo-600 hover:underline">Logout</button>
    </div>
  </header>
);

export default Header;
