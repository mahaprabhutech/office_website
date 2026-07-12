import { createContext, useContext, useMemo, useState } from 'react';
import api from '../services/api';

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const [user, setUser] = useState(() => {
    try {
      return JSON.parse(localStorage.getItem('mahaprabhu_admin_user'));
    } catch {
      return null;
    }
  });

  const login = async (email, password) => {
    const { data } = await api.post('/auth/login', { email, password });
    localStorage.setItem('mahaprabhu_admin_token', data.token);
    localStorage.setItem('mahaprabhu_admin_user', JSON.stringify(data.user));
    setUser(data.user);
  };

  const logout = async () => {
    try { await api.post('/auth/logout'); } catch { /* Clear local auth anyway. */ }
    localStorage.removeItem('mahaprabhu_admin_token');
    localStorage.removeItem('mahaprabhu_admin_user');
    setUser(null);
  };

  const value = useMemo(() => ({
    user,
    login,
    logout,
    isAuthenticated: Boolean(user && localStorage.getItem('mahaprabhu_admin_token')),
  }), [user]);

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
}

export const useAuth = () => useContext(AuthContext);
