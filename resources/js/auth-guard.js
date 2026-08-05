document.documentElement.style.display = 'none';
(async function checkAuth() {
  const token = localStorage.getItem('token');
  if (!token) {
    window.location.href = '/login';
    return;
  }
  try {
    const response = await fetch('/api/users', {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    });
    if (response.ok) {
      document.documentElement.style.display = '';
    } else {
      localStorage.removeItem('token');
      window.location.href = '/login';
    }
  } catch (error) {
    localStorage.removeItem('token');
    window.location.href = '/login';
  }
})();
