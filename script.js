// Menu mobile acessível
const navToggle = document.querySelector('.nav-toggle');
const navLinks = document.getElementById('nav-links');
if (navToggle && navLinks) {
  navToggle.addEventListener('click', function () {
    const expanded = navLinks.classList.toggle('ativo');
    navToggle.setAttribute('aria-expanded', expanded);
  });
}

// Tema claro/escuro com persistência
const themeBtn = document.getElementById('toggle-theme');
const themeIcon = document.getElementById('theme-icon');
function setTheme(dark) {
  document.body.classList.toggle('dark-mode', dark);
  if (themeIcon) themeIcon.textContent = dark ? '☀️' : '🌙';
  localStorage.setItem('pegaeusa-theme', dark ? 'dark' : 'light');
}
if (themeBtn && themeIcon) {
  const saved = localStorage.getItem('pegaeusa-theme');
  setTheme(saved === 'dark');
  themeBtn.addEventListener('click', () => {
    setTheme(!document.body.classList.contains('dark-mode'));
  });
}



// Modal Sobre Nós (se existir)
const sobreNosBtn = document.getElementById('sobre-nos-btn');
const sobreNosModal = document.getElementById('sobre-nos-modal');
const closeSobreNos = document.getElementById('close-sobre-nos');
if (sobreNosBtn && sobreNosModal && closeSobreNos) {
  sobreNosBtn.addEventListener('click', () => sobreNosModal.classList.add('ativa'));
  closeSobreNos.addEventListener('click', () => sobreNosModal.classList.remove('ativa'));
  sobreNosModal.addEventListener('mousedown', (e) => {
    if (e.target === sobreNosModal) sobreNosModal.classList.remove('ativa');
  });
  document.addEventListener('keydown', (e) => {
    if (sobreNosModal.classList.contains('ativa') && e.key === 'Escape') {
      sobreNosModal.classList.remove('ativa');
    }
  });
}

// Botão voltar ao topo (se existir)
const btnTopo = document.getElementById('voltar-topo');
window.addEventListener('scroll', () => {
  if (btnTopo) btnTopo.style.display = window.scrollY > 300 ? 'block' : 'none';
});
if (btnTopo) {
  btnTopo.addEventListener('click', () => {
    window.scrollTo({top: 0, behavior: 'smooth'});
  });
}

// MODAIS DE ADICIONAR E EDITAR ROUPA
const btnAbrirAdd = document.getElementById('abrir-modal-adicionar');
const modalAdd = document.getElementById('modal-adicionar-roupa');
const btnFecharAdd = document.getElementById('fechar-modal-adicionar');

if (btnAbrirAdd && modalAdd && btnFecharAdd) {
  btnAbrirAdd.addEventListener('click', () => modalAdd.classList.add('ativa'));
  btnFecharAdd.addEventListener('click', () => modalAdd.classList.remove('ativa'));
  modalAdd.addEventListener('mousedown', (e) => {
    if (e.target === modalAdd) modalAdd.classList.remove('ativa');
  });
  document.addEventListener('keydown', (e) => {
    if (modalAdd.classList.contains('ativa') && e.key === 'Escape') {
      modalAdd.classList.remove('ativa');
    }
  });
}

const modalEdit = document.getElementById('modal-editar-roupa');
const btnFecharEdit = document.getElementById('fechar-modal-editar');

if (modalEdit && btnFecharEdit) {
  btnFecharEdit.addEventListener('click', () => modalEdit.classList.remove('ativa'));
  modalEdit.addEventListener('mousedown', (e) => {
    if (e.target === modalEdit) modalEdit.classList.remove('ativa');
  });
  document.addEventListener('keydown', (e) => {
    if (modalEdit.classList.contains('ativa') && e.key === 'Escape') {
      modalEdit.classList.remove('ativa');
    }
  });
}

// Função global para abrir o modal de edição (chame no botão editar)
window.abrirModalEditar = function(id, nome, tamanho, quantidade, tipo, valor) {
  document.getElementById('editar-id').value = id;
  document.getElementById('editar-nome').value = nome;
  document.getElementById('editar-tamanho').value = tamanho;
  document.getElementById('editar-quantidade').value = quantidade;
  document.getElementById('editar-tipo').value = tipo;
  document.getElementById('editar-valor').value = valor;
  modalEdit.classList.add('ativa');
};

window.alugarRoupa = function(id, preco, quantidadeDisponivel) {
  document.getElementById('alugar-id').value = id;
  document.getElementById('alugar-quantidade').max = quantidadeDisponivel;
  document.getElementById('alugar-quantidade').value = 1;
  document.getElementById('alugar-dias').value = 1;
  document.getElementById('modal-alugar-roupa').classList.add('ativa');
};

// Fechar modal
document.getElementById('fechar-modal-alugar').onclick = function() {
  document.getElementById('modal-alugar-roupa').classList.remove('ativa');
};

// Submissão do aluguel
document.getElementById('form-alugar-roupa').onsubmit = function(e) {
  e.preventDefault();
  const id = document.getElementById('alugar-id').value;
  const quantidade = document.getElementById('alugar-quantidade').value;
  const dias = document.getElementById('alugar-dias').value;
  fetch('PHP/alugar_roupa.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `id=${id}&quantidade=${quantidade}&dias=${dias}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(`Roupa alugada!\nTotal a pagar: R$ ${data.total.toFixed(2).replace('.', ',')}`);
      location.reload();
    } else {
      alert(data.msg || 'Erro ao alugar roupa.');
    }
  })
  .catch(() => alert('Erro de comunicação com o servidor.'));
};


function excluirRoupa(id) {
  if (!confirm('Tem certeza que deseja excluir esta roupa?')) return;
  fetch('PHP/excluir_roupa.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `id=${id}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert('Roupa excluída com sucesso!');
      location.reload();
    } else {
      alert(data.msg || 'Erro ao excluir roupa.');
    }
  })
  .catch(() => alert('Erro de comunicação com o servidor.'));
}

document.querySelectorAll('.filtro-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    // Remove classe ativa de todos
    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('ativo'));
    this.classList.add('ativo');
    const categoria = this.getAttribute('data-categoria');
    document.querySelectorAll('.estoque .item').forEach(item => {
      if (categoria === 'geral' || item.getAttribute('data-categoria') === categoria) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  });
});

function devolverRoupa(id) {
  if (!confirm('Deseja devolver esta roupa?')) return;
  fetch('PHP/devolver_roupa.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `id=${id}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert('Roupa devolvida com sucesso!');
      location.reload();
    } else {
      alert(data.msg || 'Erro ao devolver roupa.');
    }
  })
  .catch(() => alert('Erro de comunicação com o servidor.'));
}