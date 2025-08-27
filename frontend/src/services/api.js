import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  headers: { 'Accept': 'application/json' }
});

// Interceptor untuk secara otomatis menyertakan token otentikasi di setiap permintaan
apiClient.interceptors.request.use(config => {
  const token = localStorage.getItem('authToken');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export const api = {
  // Otentikasi
  login: (credentials) => apiClient.post('/login', credentials),
  logout: () => apiClient.post('/logout'),
  getCurrentUser: () => apiClient.get('/user'),

  // Admin: Manajemen Pengguna
  getUsers: () => apiClient.get('/admin/users'),
  getUser: (id) => apiClient.get(`/admin/users/${id}`),
  createUser: (userData) => apiClient.post('/admin/users', userData),
  updateUser: (id, userData) => apiClient.put(`/admin/users/${id}`, userData),
  deleteUser: (id) => apiClient.delete(`/admin/users/${id}`),

  // Admin: Manajemen Jurnal
  adminGetJournals: () => apiClient.get('/admin/journals'),
  adminUpdateJournal: (id, data) => apiClient.put(`/admin/journals/${id}`, data),
  adminDeleteJournal: (id) => apiClient.delete(`/admin/journals/${id}`),
  adminApproveEditRequest: (id) => apiClient.patch(`/admin/journals/${id}/approve-edit`),

  // Pengelola: Manajemen Jurnal
  getJournals: () => apiClient.get('/journals'),
  getJournal: (id) => apiClient.get(`/journals/${id}`),
  createJournal: (journalData) => apiClient.post('/journals', journalData),
  updateJournal: (id, journalData) => apiClient.put(`/journals/${id}`, journalData),
  submitJournalForApproval: (id) => apiClient.patch(`/journals/${id}/submit`),
  requestJournalEdit: (id) => apiClient.patch(`/journals/${id}/request-edit`),
};