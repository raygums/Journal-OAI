import React, { useState, useEffect } from 'react';
import { api } from '../../services/api.js';
import { CreateUserPage } from './CreateUserPage.jsx';
import { EditUserPage } from './EditUserPage.jsx';

const UsersPage = () => {
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [view, setView] = useState({ name: 'list', id: null });

    const fetchUsers = () => {
        setLoading(true); setError(null);
        api.getUsers()
            .then(response => { setUsers(response.data); })
            .catch(err => { setError("Failed to fetch users."); console.error(err); })
            .finally(() => setLoading(false));
    };

    useEffect(() => {
        if (view.name === 'list') {
            fetchUsers();
        }
    }, [view]);

    const handleDelete = (userId) => {
        if (window.confirm('Are you sure you want to delete this user?')) {
            api.deleteUser(userId)
                .then(() => {
                    alert('User deleted successfully!');
                    fetchUsers();
                })
                .catch(err => {
                    alert('Failed to delete user. ' + (err.response?.data?.message || ''));
                });
        }
    };

    if (view.name === 'create') {
        return <CreateUserPage setView={setView} />;
    }
    
    if (view.name === 'edit') {
        return <EditUserPage userId={view.id} setView={setView} />;
    }

    return (
        <div className="p-8">
            <div className="flex justify-between items-center mb-6">
                <h1 className="text-3xl font-bold text-gray-800">Users Management</h1>
                <button onClick={() => setView({ name: 'create' })} className="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-colors">Add New Pengelola</button>
            </div>
            <div className="bg-white rounded-lg shadow-lg overflow-hidden">
                <table className="w-full">
                    <thead className="bg-gray-50">
                        <tr>
                            <th className="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                            <th className="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                            <th className="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                            <th className="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Faculty</th>
                            <th className="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-200">
                        {loading ? (<tr><td colSpan="5" className="p-4 text-center text-gray-500">Loading...</td></tr>)
                        : error ? (<tr><td colSpan="5" className="p-4 text-center text-red-500">{error}</td></tr>)
                        : users.map(user => (
                            <tr key={user.id} className="hover:bg-gray-50">
                                <td className="p-4 text-sm text-gray-700">{user.id}</td>
                                <td className="p-4 text-sm text-gray-900 font-medium">{user.name}</td>
                                <td className="p-4 text-sm text-gray-700">{user.email}</td>
                                <td className="p-4 text-sm text-gray-700">{user.faculty}</td>
                                <td className="p-4 text-sm space-x-2">
                                    <button onClick={() => setView({ name: 'edit', id: user.id })} className="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-1 px-3 rounded text-xs">Edit</button>
                                    <button onClick={() => handleDelete(user.id)} className="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs">Delete</button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default UsersPage;