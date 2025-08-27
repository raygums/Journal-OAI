import React, { useState, useEffect } from 'react';
import { api } from '../../services/api.js';

// Komponen kecil untuk menampilkan label status dengan warna
const StatusLabel = ({ status }) => {
  const statusMap = {
    draft: 'bg-gray-200 text-gray-800',
    pending_approval: 'bg-yellow-200 text-yellow-800',
    needs_revision: 'bg-orange-200 text-orange-800',
    published: 'bg-green-200 text-green-800',
    edit_requested: 'bg-blue-200 text-blue-800',
  };
  return (
    <span className={`px-2 py-1 text-xs font-semibold rounded-full ${statusMap[status] || 'bg-gray-200'}`}>
      {status.replace('_', ' ').toUpperCase()}
    </span>
  );
};

const JournalManagementPage = () => {
  const [journals, setJournals] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [selectedJournal, setSelectedJournal] = useState(null); // Untuk modal verifikasi

  const fetchJournals = () => {
    setLoading(true);
    setError(null);
    api.adminGetJournals()
      .then(response => setJournals(response.data))
      .catch(err => setError(`Failed to fetch journals: ${err.message}`))
      .finally(() => setLoading(false));
  };

  useEffect(fetchJournals, []);
  
  // Logika untuk modal verifikasi
  const handleVerifyClick = (journal) => {
    setSelectedJournal(journal);
  };

  const closeVerificationModal = () => {
    setSelectedJournal(null);
  };

  const handleUpdateJournal = (id, data) => {
    api.adminUpdateJournal(id, data)
      .then(() => {
        alert('Journal updated successfully!');
        closeVerificationModal();
        fetchJournals(); // Refresh data
      })
      .catch(err => {
        alert('Failed to update journal. ' + (err.response?.data?.message || ''));
      });
  };

  return (
    <div className="p-8">
      <h1 className="text-3xl font-bold text-gray-800 mb-6">Journal Management</h1>
      <div className="bg-white rounded-lg shadow-lg overflow-x-auto">
        <table className="w-full">
          <thead className="bg-gray-50">
            <tr>
              <th className="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Title</th>
              <th className="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Submitted By</th>
              <th className="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
              <th className="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Submission Date</th>
              <th className="p-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-200">
            {loading ? (<tr><td colSpan="5" className="p-4 text-center text-gray-500">Loading...</td></tr>)
            : error ? (<tr><td colSpan="5" className="p-4 text-center text-red-500">{error}</td></tr>)
            : journals.map(journal => (
              <tr key={journal.id} className="hover:bg-gray-50">
                <td className="p-4 text-sm text-gray-900 font-medium">{journal.display_title}</td>
                <td className="p-4 text-sm text-gray-700">{journal.user?.name || 'N/A'}</td>
                <td className="p-4 text-sm"><StatusLabel status={journal.status} /></td>
                <td className="p-4 text-sm text-gray-700">{new Date(journal.created_at).toLocaleDateString()}</td>
                <td className="p-4 text-sm">
                  <button 
                    onClick={() => handleVerifyClick(journal)}
                    className="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-1 px-3 rounded text-xs"
                    disabled={!['pending_approval', 'edit_requested'].includes(journal.status)}
                  >
                    Review
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
      {selectedJournal && <VerificationModal journal={selectedJournal} onClose={closeVerificationModal} onUpdate={handleUpdateJournal} />}
    </div>
  );
};

// Komponen Modal untuk Verifikasi
const VerificationModal = ({ journal, onClose, onUpdate }) => {
    const [oaiLink, setOaiLink] = useState(journal.oai_link || '');
    const [newStatus, setNewStatus] = useState('');

    const handleSubmit = () => {
        if (!oaiLink || !newStatus) {
            alert('Please fill OAI Link and select a new status.');
            return;
        }
        onUpdate(journal.id, { oai_link: oaiLink, status: newStatus });
    };

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div className="bg-white rounded-lg shadow-xl p-8 max-w-lg w-full">
                <h2 className="text-2xl font-bold mb-4">Review Submission: {journal.display_title}</h2>
                <div className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700">OAI Link (Required)</label>
                        <input type="url" value={oaiLink} onChange={(e) => setOaiLink(e.target.value)} className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="https://..."/>
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Action</label>
                        <select value={newStatus} onChange={(e) => setNewStatus(e.target.value)} className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md bg-white">
                            <option value="">-- Select new status --</option>
                            <option value="published">Publish</option>
                            <option value="needs_revision">Request Revision</option>
                        </select>
                    </div>
                    <div className="text-sm text-gray-600">
                        <p><strong>Submitted by:</strong> {journal.user?.name}</p>
                        <p><strong>Email:</strong> {journal.user?.email}</p>
                        <p><strong>Faculty:</strong> {journal.user?.faculty}</p>
                        <p><strong>Description:</strong> {journal.description}</p>
                    </div>
                </div>
                <div className="mt-6 flex justify-end space-x-4">
                    <button onClick={onClose} className="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Cancel</button>
                    <button onClick={handleSubmit} className="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Submit Action</button>
                </div>
            </div>
        </div>
    );
};

export default JournalManagementPage;
