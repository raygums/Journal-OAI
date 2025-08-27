import React from 'react';

const UserIcon = () => (<svg xmlns="http://www.w.3.org/2000/svg" className="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path fillRule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clipRule="evenodd" /></svg>);
const JournalIcon = () => (<svg xmlns="http://www.w.3.org/2000/svg" className="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.255 0 2.443-.29 3.5-.804V4.804zM14.5 4c1.255 0 2.443.29 3.5.804v10A7.969 7.969 0 0114.5 16c-1.255 0-2.443-.29-3.5-.804V4.804A7.968 7.968 0 0114.5 4z" /></svg>);

const Sidebar = ({ userRole, menuItems, activePage, setActivePage }) => (
  <aside className="w-64 bg-indigo-800 text-white flex flex-col flex-shrink-0">
    <div className="h-16 flex items-center justify-center text-2xl font-bold border-b border-indigo-700">
      {userRole === 'admin' ? 'Admin Panel' : 'Pengelola Panel'}
    </div>
    <nav className="flex-1 px-4 py-6 space-y-2">
      {menuItems.map(item => (
        <a 
          key={item.key}
          href="#" 
          onClick={() => setActivePage({ name: item.key })} 
          className={`flex items-center px-4 py-2 rounded-lg transition-colors ${activePage.name === item.key ? 'bg-indigo-600' : 'hover:bg-indigo-700'}`}
        >
          {item.key.includes('user') ? <UserIcon /> : <JournalIcon />}
          {item.label}
        </a>
      ))}
    </nav>
  </aside>
);

export default Sidebar;