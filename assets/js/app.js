// CRM Nepal - Main JavaScript

// Modal Functions
function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = 'none';
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal').forEach(m => m.style.display = 'none');
    }
});

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function() {
        this.closest('.modal').style.display = 'none';
    });
});

// FAQ Accordion
function toggleFaq(btn) {
    const answer = btn.nextElementSibling;
    const isOpen = answer.classList.contains('open');
    
    // Close all
    document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('open'));
    document.querySelectorAll('.faq-question').forEach(q => q.classList.remove('active'));
    
    if (!isOpen) {
        answer.classList.add('open');
        btn.classList.add('active');
    }
}

// Chatbot Widget
let chatStep = 'welcome';

function toggleChatbot() {
    const window_ = document.getElementById('chatbotWindow');
    if (window_.style.display === 'none' || !window_.style.display) {
        window_.style.display = 'flex';
        window_.style.flexDirection = 'column';
    } else {
        window_.style.display = 'none';
    }
}

function addChatMessage(text, type = 'bot') {
    const messages = document.getElementById('chatbotMessages');
    const div = document.createElement('div');
    div.className = 'chat-message ' + type;
    div.innerHTML = '<p>' + text + '</p>';
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
}

function addQuickReplies(options) {
    const messages = document.getElementById('chatbotMessages');
    const div = document.createElement('div');
    div.className = 'chat-quick-replies';
    options.forEach(opt => {
        const btn = document.createElement('button');
        btn.className = 'quick-reply';
        btn.textContent = opt.label;
        btn.onclick = function() { opt.action(); };
        div.appendChild(btn);
    });
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
}

function clearQuickReplies() {
    document.querySelectorAll('.chat-quick-replies').forEach(el => el.remove());
}

function chatQuickReply(type) {
    clearQuickReplies();
    
    switch(type) {
        case 'demo':
            addChatMessage('Great! Let me get your details to book a demo.');
            chatStep = 'name';
            document.getElementById('chatForm').style.display = 'block';
            document.getElementById('chatName').focus();
            break;
        case 'features':
            addChatMessage('CRM Nepal offers: Contact Management, Deal Pipeline, Invoice Management with VAT/PAN, Support Tickets, Reports & Analytics, and Bilingual Interface (English/Nepali).');
            addQuickReplies([
                { label: 'Book a Demo', action: function() { chatQuickReply('demo'); } },
                { label: 'View Pricing', action: function() { chatQuickReply('pricing'); } }
            ]);
            break;
        case 'pricing':
            addChatMessage('Our pricing plans:\n\nStarter: NPR 1,999/mo - 100 contacts, 5 users\nProfessional: NPR 4,999/mo - 1,000 contacts, 15 users\nEnterprise: NPR 9,999/mo - Unlimited\n\nAll plans include eSewa, Khalti, VAT/PAN support.');
            addQuickReplies([
                { label: 'Book a Demo', action: function() { chatQuickReply('demo'); } },
                { label: 'View Features', action: function() { chatQuickReply('features'); } }
            ]);
            break;
    }
}

function submitChatForm() {
    const name = document.getElementById('chatName').value;
    const email = document.getElementById('chatEmail').value;
    const country = document.getElementById('chatCountry').value;
    const phone = document.getElementById('chatPhone').value;
    
    if (!name || !email) {
        alert('Please fill in your name and email');
        return;
    }
    
    document.getElementById('chatForm').style.display = 'none';
    
    addChatMessage('Thank you, ' + name + '! We have your details and will contact you at ' + email + ' shortly. Is there anything else I can help with?');
    
    // Submit to API
    fetch('/api/chatbot-submit', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, email, country, phone, subject: 'Chatbot Demo Request' })
    }).then(r => r.json()).catch(() => {});
    
    addQuickReplies([
        { label: 'View Features', action: function() { chatQuickReply('features'); } },
        { label: 'View Pricing', action: function() { chatQuickReply('pricing'); } }
    ]);
    
    // Clear form
    document.getElementById('chatName').value = '';
    document.getElementById('chatEmail').value = '';
    document.getElementById('chatPhone').value = '';
}

function sendChatMessage() {
    const input = document.getElementById('chatInput');
    const text = input.value.trim();
    if (!text) return;
    
    addChatMessage(text, 'user');
    input.value = '';
    
    // Simple bot responses
    const lower = text.toLowerCase();
    if (lower.includes('pricing') || lower.includes('price') || lower.includes('cost')) {
        setTimeout(function() { chatQuickReply('pricing'); }, 500);
    } else if (lower.includes('feature') || lower.includes('what')) {
        setTimeout(function() { chatQuickReply('features'); }, 500);
    } else if (lower.includes('demo') || lower.includes('try') || lower.includes('book')) {
        setTimeout(function() { chatQuickReply('demo'); }, 500);
    } else if (lower.includes('hello') || lower.includes('hi') || lower.includes('hey')) {
        setTimeout(function() {
            addChatMessage('Hello! How can I help you today?');
            addQuickReplies([
                { label: 'Book a Demo', action: function() { chatQuickReply('demo'); } },
                { label: 'View Features', action: function() { chatQuickReply('features'); } },
                { label: 'Pricing Info', action: function() { chatQuickReply('pricing'); } }
            ]);
        }, 500);
    } else if (lower.includes('nepal') || lower.includes('esewa') || lower.includes('khalti') || lower.includes('vat')) {
        setTimeout(function() {
            addChatMessage('Yes! CRM Nepal is built specifically for Nepali businesses. We support eSewa, Khalti, bank transfers, and cash payments. VAT is automatically calculated at 13%, and we support PAN numbers on invoices. The interface is fully bilingual in English and Nepali.');
        }, 500);
    } else {
        setTimeout(function() {
            addChatMessage("Thanks for your message! I'd be happy to help. Would you like to book a demo, learn about features, or see pricing?");
            addQuickReplies([
                { label: 'Book a Demo', action: function() { chatQuickReply('demo'); } },
                { label: 'View Features', action: function() { chatQuickReply('features'); } },
                { label: 'Pricing Info', action: function() { chatQuickReply('pricing'); } }
            ]);
        }, 500);
    }
}

// Drag and Drop for Pipeline
function allowDrop(ev) {
    ev.preventDefault();
    ev.currentTarget.style.background = '#F0F9FF';
}

function drag(ev) {
    ev.dataTransfer.setData('text/plain', ev.target.dataset.id);
    ev.target.style.opacity = '0.5';
}

function drop(ev) {
    ev.preventDefault();
    ev.currentTarget.style.background = '';
    
    const dealId = ev.dataTransfer.getData('text/plain');
    const newStage = ev.currentTarget.dataset.stage;
    
    if (!dealId || !newStage) return;
    
    // Update via AJAX
    fetch('/pipeline/updateStage', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'deal_id=' + dealId + '&stage=' + newStage
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(err => {
        console.error('Error:', err);
        location.reload();
    });
}

// Reset opacity when drag ends
document.addEventListener('dragend', function(e) {
    if (e.target.classList.contains('kanban-card')) {
        e.target.style.opacity = '1';
    }
});

// Form Validation
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let valid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = '#EF4444';
                valid = false;
            } else {
                field.style.borderColor = '';
            }
        });
        
        if (!valid) {
            e.preventDefault();
        }
    });
});

// Auto-hide alerts after 5 seconds
document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transition = 'opacity 0.3s ease';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});