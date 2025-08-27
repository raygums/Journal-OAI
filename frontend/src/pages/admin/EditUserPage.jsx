import React, { useState, useEffect } from 'react';
import { api } from '../../services/api.js';

export const EditUserPage = ({ userId, setView }) => {
    const [formData, setFormData] = useState({ name: '', email: '', faculty: '', password: '', password_confirmation: '' });
    const [status, setStatus] = useState({ loading: true, error: null });

    useEffect(() => {
        api.getUser(userId)
            .then(response => {
                const { name, email, faculty } = response.data;
                setFormData({ name, email, faculty: faculty || '', password: '', password_confirmation: '' });
                setStatus({ loading: false, error: null });
            })
            .catch(err => setStatus({ loading: false, error: 'Failed to fetch user data.' }));
    }, [userId]);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setStatus({ loading: true, error: null });
        try {
            await api.updateUser(userId, formData);
            setView({ name: 'list' });
        } catch (error) {
            const errorMessage = error.response?.data?.errors ? Object.values(error.response.data.errors).flat().join(' ') : (error.response?.data?.message || 'An error occurred.');
            setStatus({ loading: false, error: errorMessage });
        }
    };

    if (status.loading) return <div className="p-8 text-center">Loading user data...</div>;

    return (
        <div className="p-8">
            <button onClick={() => setView({ name: 'list' })} className="text-indigo-600 hover:underline mb-6 inline-block">← Back to Users</button>
            <div className="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-lg">
                <h2 className="text-2xl font-bold text-gray-800 mb-6 text-center">Edit User (ID: {userId})</h2>
                {status.error && <div className="bg-red-100 text-red-700 p-4 mb-4 rounded-md">{status.error}</div>}
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div><label className="block text-sm font-medium text-gray-600">Nama Lengkap</label><input type="text" name="name" value={formData.name} onChange={handleChange} className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required /></div>
                    <div><label className="block text-sm font-medium text-gray-600">Email</label><input type="email" name="email" value={formData.email} onChange={handleChange} className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required /></div>
                    <div><label className="block text-sm font-medium text-gray-600">Fakultas</label><input type="text" name="faculty" value={formData.faculty} onChange={handleChange} className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required /></div>
                    <div><label className="block text-sm font-medium text-gray-600">New Password (Optional)</label><input type="password" name="password" value={formData.password} onChange={handleChange} className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" /></div>
                    <div><label className="block text-sm font-medium text-gray-600">Confirm New Password</label><input type="password" name="password_confirmation" value={formData.password_confirmation} onChange={handleChange} className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" /></div>
                    <div><button type="submit" disabled={status.loading} className="w-full flex justify-center py-2 px-4 border rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-400">{status.loading ? 'Updating...' : 'Update Account'}</button></div>
                </form>
            </div>
        </div>
    );
};