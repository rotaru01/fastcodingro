const API_BASE = 'https://fast-coding-agency--fast-coding-d1143.europe-west4.hosted.app';

// --- Navbar scroll effect ---
const nav = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  if (window.scrollY > 20) {
    nav.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-sm');
    nav.classList.remove('bg-transparent');
  } else {
    nav.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-sm');
    nav.classList.add('bg-transparent');
  }
});

// --- Mobile menu ---
const mobileBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
const mobileIcon = document.getElementById('mobile-icon');
mobileBtn.addEventListener('click', () => {
  const isOpen = !mobileMenu.classList.contains('hidden');
  if (isOpen) {
    mobileMenu.classList.add('hidden');
    mobileIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />';
  } else {
    mobileMenu.classList.remove('hidden');
    mobileIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />';
  }
});
// Close mobile menu on link click
mobileMenu.querySelectorAll('a').forEach(a => {
  a.addEventListener('click', () => {
    mobileMenu.classList.add('hidden');
    mobileIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />';
  });
});

// --- Contact form ---
const contactForm = document.getElementById('contact-form');
const submitBtn = document.getElementById('submit-btn');
const submitText = document.getElementById('submit-text');
const successMsg = document.getElementById('success-msg');

contactForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const name = document.getElementById('cf-name').value.trim();
  const email = document.getElementById('cf-email').value.trim();
  const phone = document.getElementById('cf-phone').value.trim();
  const project = document.getElementById('cf-project').value.trim();

  if (!name || !email || !project) return;

  submitBtn.disabled = true;
  submitText.textContent = 'Se trimite...';

  try {
    const res = await fetch(API_BASE + '/api/contact', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name, email, phone, project }),
    });
    if (res.ok) {
      successMsg.classList.remove('hidden');
      contactForm.reset();
    } else {
      alert('Eroare la trimitere. Încercați din nou.');
    }
  } catch {
    alert('Eroare la trimitere. Încercați din nou.');
  } finally {
    submitBtn.disabled = false;
    submitText.textContent = 'Trimite & Primește Demo Gratuit';
  }
});

// --- Cookie Consent ---
const cookieBanner = document.getElementById('cookie-banner');
if (!localStorage.getItem('cookie-consent')) {
  cookieBanner.classList.remove('hidden');
}
document.getElementById('cookie-accept')?.addEventListener('click', () => {
  localStorage.setItem('cookie-consent', 'accepted');
  cookieBanner.classList.add('hidden');
});
document.getElementById('cookie-decline')?.addEventListener('click', () => {
  localStorage.setItem('cookie-consent', 'declined');
  cookieBanner.classList.add('hidden');
});

// --- Chat Widget ---
const chatBtn = document.getElementById('chat-open-btn');
const chatWindow = document.getElementById('chat-window');
const chatClose = document.getElementById('chat-close-btn');
const chatInput = document.getElementById('chat-input');
const chatSend = document.getElementById('chat-send');
const chatMessages = document.getElementById('chat-messages');

let messages = [
  { role: 'assistant', content: 'Bună! Sunt aici să te ajut cu întrebări despre dezvoltare software. Cu ce te pot ajuta?', timestamp: new Date() }
];
let isLoading = false;

function renderMessages() {
  chatMessages.innerHTML = messages.map(m => {
    const time = m.timestamp.toLocaleTimeString('ro-RO', { hour: '2-digit', minute: '2-digit' });
    const isUser = m.role === 'user';
    return `<div class="flex ${isUser ? 'justify-end' : 'justify-start'}">
      <div class="max-w-[80%] rounded-2xl px-4 py-2.5 ${isUser ? 'bg-indigo-600 text-white' : 'bg-white text-zinc-900 shadow-sm'}">
        <p class="text-sm whitespace-pre-wrap leading-relaxed">${m.content}</p>
        <span class="text-xs mt-1 block ${isUser ? 'text-white/70' : 'text-zinc-500'}">${time}</span>
      </div>
    </div>`;
  }).join('');

  if (isLoading) {
    chatMessages.innerHTML += `<div class="flex justify-start">
      <div class="bg-white rounded-2xl px-4 py-3 shadow-sm">
        <div class="flex gap-1.5">
          <div class="w-2 h-2 bg-zinc-400 rounded-full animate-bounce-1"></div>
          <div class="w-2 h-2 bg-zinc-400 rounded-full animate-bounce-2"></div>
          <div class="w-2 h-2 bg-zinc-400 rounded-full animate-bounce-3"></div>
        </div>
      </div>
    </div>`;
  }
  chatMessages.scrollTop = chatMessages.scrollHeight;
}

function openChat() {
  chatBtn.classList.add('hidden');
  chatWindow.classList.remove('hidden');
  renderMessages();
  chatInput.focus();
}

function closeChat() {
  chatWindow.classList.add('hidden');
  chatBtn.classList.remove('hidden');
}

async function sendMessage() {
  const text = chatInput.value.trim();
  if (!text || isLoading) return;

  messages.push({ role: 'user', content: text, timestamp: new Date() });
  chatInput.value = '';
  isLoading = true;
  chatSend.disabled = true;
  renderMessages();

  try {
    const res = await fetch(API_BASE + '/api/chat', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        messages: messages.map(m => ({ role: m.role, content: m.content })),
        locale: 'ro',
      }),
    });
    const data = await res.json();
    if (!res.ok) throw new Error(data.error);
    messages.push({ role: 'assistant', content: data.message, timestamp: new Date() });
  } catch {
    messages.push({ role: 'assistant', content: 'Scuze, a apărut o eroare. Încearcă din nou.', timestamp: new Date() });
  } finally {
    isLoading = false;
    chatSend.disabled = false;
    renderMessages();
  }
}

chatBtn.addEventListener('click', openChat);
chatClose.addEventListener('click', closeChat);
chatSend.addEventListener('click', sendMessage);
chatInput.addEventListener('keypress', (e) => {
  if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
});
chatInput.addEventListener('input', () => {
  chatSend.disabled = !chatInput.value.trim();
});

renderMessages();
