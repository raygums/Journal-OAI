import React, { useState } from 'react';
import Sidebar from '../components/common/Sidebar.jsx';
import Header from '../components/common/Header.jsx';
// Import laman pengelola di sini nanti
// import MyJournalsPage from '../pages/pengelola/MyJournalsPage.jsx';

const PengelolaLayout = ({ user, onLogout }) => {
  const [activePage, setActivePage] = useState({ name: 'my-journals' });

  const renderContent = () => {
    switch (activePage.name) {
      // case 'my-journals':
      //   return <MyJournalsPage />;
      default:
        return <div className="p-8"><h1 className="text-3xl font-bold">Pengelola Dashboard</h1><p>Selamat datang, {user.name}.</p></div>;
    }
  };

  const menuItems = [
    { key: 'my-journals', label: 'My Journals' },
    { key: 'submit-new', label: 'Submit New Journal' }
  ];

  return (
    <div className="flex h-screen bg-gray-100 font-sans">
      <Sidebar userRole="pengelola" menuItems={menuItems} activePage={activePage} setActivePage={setActivePage} />
      <div className="flex-1 flex flex-col overflow-hidden">
        <Header user={user} onLogout={onLogout} />
        <main className="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
          {renderContent()}
        </main>
      </div>
    </div>
  );
};

export default PengelolaLayout;