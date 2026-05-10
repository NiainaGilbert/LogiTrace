// ── Declaration Page Script ────────────────────────────

// État global
let declarations = [];
let currentDeclarationId = null;

// Éléments du DOM (initialisés dans initDeclarationPage)
let addDeclarationBtn;
let declarationModal;
let closeModalBtn;
let cancelBtn;
let declarationForm;
let declarationList;
let searchInput;
let filterSelect;

// ── Point d'entrée SPA ───────────────────────────────

/**
 * Initialiser la page déclaration après injection dans le DOM (SPA)
 * Appeler cette fonction depuis le routeur SPA après avoir injecté le HTML
 */
function initDeclarationPage() {
    // Réassigner les éléments DOM après injection
    addDeclarationBtn = document.getElementById('addDeclarationBtn');
    declarationModal  = document.getElementById('declarationModal');
    closeModalBtn     = document.getElementById('closeModal');
    cancelBtn         = document.getElementById('cancelBtn');
    declarationForm   = document.getElementById('declarationForm');
    declarationList   = document.getElementById('declarationList');
    searchInput       = document.getElementById('searchReference');
    filterSelect      = document.getElementById('filterStatus');

    // Nettoyer les anciens listeners en clonant les éléments
    rebindListeners();

    // Charger les données
    loadDeclarations();
}

// Exposer globalement pour le routeur SPA
window.initDeclarationPage = initDeclarationPage;

// ── Event Listeners ──────────────────────────────────

function rebindListeners() {
    if (addDeclarationBtn) {
        addDeclarationBtn.addEventListener('click', openModal);
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }

    if (declarationModal) {
        declarationModal.addEventListener('click', (e) => {
            if (e.target === declarationModal) {
                closeModal();
            }
        });
    }

    if (declarationForm) {
        declarationForm.addEventListener('submit', handleFormSubmit);
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterDeclarations);
    }

    if (filterSelect) {
        filterSelect.addEventListener('change', filterDeclarations);
    }
}

// ── Functions ────────────────────────────────────────

/**
 * Charger toutes les déclarations de l'API
 */
async function loadDeclarations() {
    try {
        const response = await fetch('../api/declaration/read.php');
        if (!response.ok) throw new Error('Erreur lors du chargement');

        const data = await response.json();
        console.log('Données reçues:', data);

        if (data.error) {
            showError(data.error);
            declarations = [];
        } else {
            declarations = Array.isArray(data) ? data : [data];
        }

        console.log('Déclarations chargées:', declarations.length);
        renderDeclarations(declarations);
    } catch (error) {
        console.error('Erreur:', error);
        showError('Impossible de charger les déclarations');
    }
}

/**
 * Afficher les déclarations dans le tableau
 */
function renderDeclarations(items) {
    if (!declarationList) return;

    if (items.length === 0) {
        declarationList.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px;">
                    <p style="color: var(--muted);">Aucune déclaration trouvée.</p>
                </td>
            </tr>
        `;
        return;
    }

    declarationList.innerHTML = items.map(decl => `
        <tr>
            <td>
                <strong>${escapeHtml(decl.reference || 'N/A')}</strong>
            </td>
            <td>${formatDate(decl.date_de_creation)}</td>
            <td>${escapeHtml(decl.type || 'N/A')}</td>
            <td>${decl.date_soumission ? '✓' : '-'}</td>
            <td>
                <span class="status-label ${(decl.statut || 'en_attente').toLowerCase()}">
                    ${formatStatus(decl.statut)}
                </span>
            </td>
            <td>
                <div class="action-btns">
                    <button class="action-btn" title="Voir" onclick="viewDeclaration(${decl.id || 0})">
                        <i class="bx bx-show"></i>
                    </button>
                    <button class="action-btn" title="Éditer" onclick="editDeclaration(${decl.id || 0})">
                        <i class="bx bx-edit"></i>
                    </button>
                    <button class="action-btn danger" title="Supprimer" onclick="deleteDeclaration(${decl.id || 0})">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

/**
 * Filtrer les déclarations
 */
function filterDeclarations() {
    const search = searchInput?.value.toLowerCase() || '';
    const status = filterSelect?.value || '';

    const filtered = declarations.filter(decl => {
        const matchSearch = !search ||
            (decl.reference || '').toLowerCase().includes(search) ||
            (decl.type || '').toLowerCase().includes(search);
        const matchStatus = !status || decl.statut === status;
        return matchSearch && matchStatus;
    });

    renderDeclarations(filtered);
}

/**
 * Ouvrir la modal pour créer une déclaration
 */
function openModal() {
    if (declarationModal) {
        currentDeclarationId = null;
        resetForm();
        declarationModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

/**
 * Fermer la modal
 */
function closeModal() {
    if (declarationModal) {
        declarationModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        resetForm();
    }
}

/**
 * Réinitialiser le formulaire
 */
function resetForm() {
    if (declarationForm) {
        declarationForm.reset();
        currentDeclarationId = null;
        const modalTitle = document.querySelector('.modal-header h3');
        if (modalTitle) modalTitle.textContent = 'Nouvelle Déclaration';
    }
}

/**
 * Traiter la soumission du formulaire
 */
async function handleFormSubmit(e) {
    e.preventDefault();

    const formData = new FormData(declarationForm);
    const data = Object.fromEntries(formData);

    try {
        let url = '../api/declaration/create.php';
        const method = 'POST';

        if (currentDeclarationId) {
            url = '../api/declaration/update.php';
            data.id = currentDeclarationId;
        }

        const response = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        if (!response.ok) throw new Error('Erreur serveur');

        const result = await response.json();

        if (result.success !== false) {
            showSuccess(currentDeclarationId ? 'Déclaration mise à jour' : 'Déclaration créée');
            closeModal();
            loadDeclarations();
        } else {
            showError(result.message || 'Une erreur est survenue');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showError('Impossible de soumettre la déclaration');
    }
}

/**
 * Voir les détails d'une déclaration
 */
async function viewDeclaration(id) {
    try {
        const response = await fetch(`../api/declaration/read.php?id=${id}`);
        if (!response.ok) throw new Error('Non trouvé');

        const decl = await response.json();

        alert(`
            Référence: ${decl.reference || 'N/A'}
            Type: ${decl.type || 'N/A'}
            Statut: ${formatStatus(decl.statut || 'en_attente')}
            Date de création: ${formatDate(decl.date_de_creation) || 'N/A'}
            Date de soumission: ${decl.date_soumission ? formatDate(decl.date_soumission) : 'Non soumise'}
        `);
    } catch (error) {
        showError('Impossible de charger la déclaration');
    }
}

/**
 * Éditer une déclaration
 */
async function editDeclaration(id) {
    try {
        const response = await fetch(`../api/declaration/read.php?id=${id}`);
        if (!response.ok) throw new Error('Non trouvé');

        const decl = await response.json();

        document.getElementById('reference').value = decl.reference || '';
        document.getElementById('type').value = decl.type || '';
        document.getElementById('statut').value = decl.statut || '';

        if (decl.date_soumission) {
            const date = new Date(decl.date_soumission);
            const formatted = date.toISOString().slice(0, 16);
            document.getElementById('date_soumission').value = formatted;
        }

        currentDeclarationId = id;
        const modalTitle = document.querySelector('.modal-header h3');
        if (modalTitle) modalTitle.textContent = 'Éditer Déclaration';

        openModal();
    } catch (error) {
        showError('Impossible de charger la déclaration');
    }
}

/**
 * Supprimer une déclaration
 */
async function deleteDeclaration(id) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cette déclaration ?')) {
        return;
    }

    try {
        const response = await fetch('../api/declaration/delete.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });

        if (!response.ok) throw new Error('Erreur serveur');

        const result = await response.json();

        if (result.success !== false) {
            showSuccess('Déclaration supprimée');
            loadDeclarations();
        } else {
            showError(result.message || 'Une erreur est survenue');
        }
    } catch (error) {
        console.error('Erreur:', error);
        showError('Impossible de supprimer la déclaration');
    }
}

// ── Utilities ────────────────────────────────────────

function formatDate(dateStr) {
    if (!dateStr) return '-';
    const date = new Date(dateStr);
    return date.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function formatStatus(status) {
    const labels = {
        'en_attente': 'En attente',
        'en_cours': 'En cours',
        'accepte': 'Accepté',
        'refuse': 'Refusé',
        'termine': 'Terminé'
    };
    return labels[status] || status || 'En attente';
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function showError(message) {
    const notification = document.createElement('div');
    notification.className = 'notification error';
    notification.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">×</button>
    `;
    notification.style.cssText = `
        position: fixed; top: 20px; right: 20px;
        background: rgba(244, 81, 108, 0.9); color: white;
        padding: 12px 20px; border-radius: 8px; z-index: 999;
        display: flex; align-items: center; gap: 10px;
    `;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 4000);
}

function showSuccess(message) {
    const notification = document.createElement('div');
    notification.className = 'notification success';
    notification.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">×</button>
    `;
    notification.style.cssText = `
        position: fixed; top: 20px; right: 20px;
        background: rgba(91, 214, 125, 0.9); color: white;
        padding: 12px 20px; border-radius: 8px; z-index: 999;
        display: flex; align-items: center; gap: 10px;
    `;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 4000);
}

// ── Fallback : page classique (non-SPA) ─────────────
// Si le script est chargé directement (hors SPA), initialiser normalement
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('declarationList')) {
        initDeclarationPage();
    }
});