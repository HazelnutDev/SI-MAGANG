import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
  const smoothLinks = document.querySelectorAll('a[href^="#"]');
  smoothLinks.forEach(l => l.addEventListener('click', e => {
    const id = l.getAttribute('href').slice(1);
    const el = document.getElementById(id);
    if (el) {
      e.preventDefault();
      el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }));
});

