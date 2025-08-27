import React, { useState } from 'react';
import Sidebar from '../components/common/Sidebar.jsx';
import Header from '../components/common/Header.jsx';
import UsersPage from '../pages/admin/UsersPage.jsx';
// Import laman admin lainnya di sini nanti
// import JournalManagementPage from '../pages/admin/JournalManagementPage.jsx';

const AdminLayout = ({ user, onLogout }) => {
  const [activePage, setActivePage] = useState({ name: 'users' });

  const renderContent = () => {
    switch (activePage.name) {
      case 'users':
        return <UsersPage />;
      // case 'journals':
      //   return <JournalManagementPage />;
      default:
        return <div className="p-8"><h1 className="text-3xl font-bold">Admin Dashboard</h1></div>;
    }
  };

  const menuItems = [
    { key: 'users', label: 'Users Management' },
    { key: 'journals', label: 'Journal Management' }
  ];

  return (
    <div className="flex h-screen bg-gray-100 font-sans">
      <Sidebar userRole="admin" menuItems={menuItems} activePage={activePage} setActivePage={setActivePage} />
      <div className="flex-1 flex flex-col overflow-hidden">
        <Header user={user} onLogout={onLogout} />
        <main className="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
          {renderContent()}
        </main>
      </div>
    </div>
  );
};

export default AdminLayout;