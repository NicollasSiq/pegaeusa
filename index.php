<?php
require_once 'PHP/conexao.php';
require_once 'PHP/roupa.php';
require_once 'PHP/permissoes.php';
global $conexao;
?>
<!DOCTYPE html>
<html lang="pt-BR" dir="ltr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Pega e Usa: aluguel de roupas fácil, rápido e prático. Veja nosso estoque e adicione novas peças!">
  <title>Pega e Usa</title>
  <link rel="icon" href="Imagens/favicon.jpeg" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Noto+Sans+JP:wght@700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <a href="#topo" class="skip-link"></a>
  <header id="topo" class="header" aria-label="Cabeçalho principal">
    <div class="header-content">
      <div class="logo-area">
        <img src="Imagens/WhatsApp Image 2025-05-31 at 22.11.54.jpeg" alt="Logo do Pega e Usa, um cabide estilizado" class="logo" width="48" height="48" />
        <div>
          <h1 class="titulo-jp">Pega e Usa</h1>
          <p class="slogan">Alugue roupas com praticidade e estilo</p>
        </div>
      </div>
      <nav class="navbar" aria-label="Menu principal">
        <button class="nav-toggle" aria-label="Abrir menu" aria-controls="nav-links" aria-expanded="false">
          <span class="hamburger"></span>
        </button>
        <ul class="nav-links" id="nav-links">
          <li><a href="#estoque">Estoque</a></li>
          <li><a href="#contato">Contato</a></li>
          <li>
            <a href="https://wa.me/SEUNUMEROAQUI" class="whatsapp-header" target="_blank" rel="noopener" aria-label="Fale no WhatsApp">
              <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="Ícone do WhatsApp" width="22" height="22" />
              <span>WhatsApp</span>
            </a>
          </li>
          <li>
            <button id="toggle-theme" aria-label="Alternar modo escuro/claro">
              <span id="theme-icon" aria-hidden="true">🌙</span>
            </button>
          </li>
        </ul>
        <!-- Botão para abrir o modal de adicionar roupa -->
        <?php if (isAdmin()): ?>
  <button id="abrir-modal-adicionar" class="btn-adicionar" aria-label="Adicionar roupa">Adicionar Roupa</button>
<?php endif; ?>
      </nav>
    </div>
  </header>

  <!-- Modal para adicionar roupa -->
  <div id="modal-adicionar-roupa" class="modal">
    <div class="modal-content">
      <button type="button" class="close-modal" id="fechar-modal-adicionar" aria-label="Fechar">&times;</button>
      <form id="form-adicionar-roupa" method="POST" enctype="multipart/form-data" action="PHP/adicionar_roupa.php">
        <h3>Adicionar Roupa</h3>
        <label for="nome">Nome da roupa</label>
        <input type="text" name="nome" id="nome" placeholder="Nome da roupa" required>
        <label for="tamanho">Tamanho</label>
        <input type="text" name="tamanho" id="tamanho" placeholder="Tamanho" required>
        <label for="quantidade">Quantidade</label>
        <input type="number" name="quantidade" id="quantidade" placeholder="Quantidade" min="1" required>
        <label for="foto">Foto</label>
        <input type="file" name="foto" id="foto" accept="image/*" required>
        <label for="tipo">Tipo de roupa</label>
        <select name="tipo" id="tipo" required>
          <option value="">Tipo de roupa</option>
          <option value="camiseta">Camiseta</option>
          <option value="blusa">Blusa</option>
          <option value="calca">Calça</option>
          <option value="tenis">Tênis</option>
          <option value="terno">Terno</option>
        </select>
        <label for="valor">Valor do aluguel por dia</label>
        <input type="number" name="valor" id="valor" placeholder="Valor do aluguel por dia" min="1" required>
        <button type="submit">Enviar</button>
      </form>
    </div>
  </div>

  <!-- Modal para editar roupa -->
  <div id="modal-editar-roupa" class="modal">
    <div class="modal-content">
      <button type="button" class="close-modal" id="fechar-modal-editar" aria-label="Fechar">&times;</button>
      <form id="form-editar-roupa" method="POST" enctype="multipart/form-data" action="PHP/editar_roupa.php">
        <h3>Editar Roupa</h3>
        <input type="hidden" name="id" id="editar-id">
        <label for="editar-nome">Nome da roupa</label>
        <input type="text" name="nome" id="editar-nome" placeholder="Nome da roupa" required>
        <label for="editar-tamanho">Tamanho</label>
        <input type="text" name="tamanho" id="editar-tamanho" placeholder="Tamanho" required>
        <label for="editar-quantidade">Quantidade</label>
        <input type="number" name="quantidade" id="editar-quantidade" placeholder="Quantidade" min="1" required>
        <label for="editar-tipo">Tipo de roupa</label>
        <select name="tipo" id="editar-tipo" required>
          <option value="">Tipo de roupa</option>
          <option value="camiseta">Camiseta</option>
          <option value="blusa">Blusa</option>
          <option value="calca">Calça</option>
          <option value="tenis">Tênis</option>
          <option value="terno">Terno</option>
        </select>
        <label for="editar-valor">Valor do aluguel por dia</label>
        <input type="number" name="valor" id="editar-valor" placeholder="Valor do aluguel por dia" min="1" required>
        <button type="submit">Salvar</button>
      </form>
    </div>
  </div>

  <!-- Modal Alugar Roupa -->
<div id="modal-alugar-roupa" class="modal">
  <div class="modal-content">
    <button type="button" class="close-modal" id="fechar-modal-alugar" aria-label="Fechar">&times;</button>
    <h3>Alugar Roupa</h3>
    <form id="form-alugar-roupa">
      <input type="hidden" name="id" id="alugar-id">
      <label for="alugar-quantidade">Quantidade</label>
      <input type="number" name="quantidade" id="alugar-quantidade" min="1" required>
      <label for="alugar-dias">Dias</label>
      <input type="number" name="dias" id="alugar-dias" min="1" required>
      <button type="submit">Alugar</button>
    </form>
  </div>
</div>

 
<main id="main-content" tabindex="-1">
    <!-- Seção de Estoque de Roupas -->
    <section id="estoque" class="estoque-section" aria-labelledby="estoque-titulo">
      <h2 id="estoque-titulo">Estoque</h2>
      <div class="filtros-estoque" role="tablist" aria-label="Filtrar estoque">
        <button class="filtro-btn ativo" data-categoria="geral" role="tab" aria-selected="true">Geral</button>
        <button class="filtro-btn" data-categoria="terno" role="tab" aria-selected="false">Ternos</button>
        <button class="filtro-btn" data-categoria="camiseta" role="tab" aria-selected="false">Camisetas</button>
        <button class="filtro-btn" data-categoria="calca" role="tab" aria-selected="false">Calças</button>
        <button class="filtro-btn" data-categoria="blusa" role="tab" aria-selected="false">Blusas</button>
        <button class="filtro-btn" data-categoria="tenis" role="tab" aria-selected="false">Tênis</button>
      </div>
      <div class="estoque" aria-live="polite">
        <?php foreach ($roupas as $r): ?>
          <?php if ($r->getStatus() == 'disponivel'): ?>
     <div class="item"
     id="roupa-<?php echo $r->getId(); ?>"
     data-categoria="<?php echo htmlspecialchars(strtolower($r->getTipo())); ?>">
              <h3><?php echo htmlspecialchars($r->getNome()); ?></h3>
              <p>Tamanho: <?php echo htmlspecialchars($r->getTamanho()); ?></p>
              <p>Preço: R$ <?php echo number_format($r->getPreco(), 2, ',', '.'); ?></p>
              <p>Quantidade: <?php echo htmlspecialchars($r->getQuantidade()); ?></p>
              <p>Tipo: <?php echo htmlspecialchars($r->getTipo()); ?></p>
              <div class="botoes-roupa">
                <button type="button"
                  class="btn-alugar"
                  onclick="alugarRoupa(<?php echo $r->getId(); ?>, <?php echo $r->getPreco(); ?>, <?php echo $r->getQuantidade(); ?>)"
                >Alugar</button>
                <?php if (isAdmin()): ?>
                  <button type="button"
                    class="btn-editar"
                    onclick="abrirModalEditar(
                      <?php echo $r->getId(); ?>,
                      '<?php echo htmlspecialchars($r->getNome(), ENT_QUOTES); ?>',
                      '<?php echo htmlspecialchars($r->getTamanho(), ENT_QUOTES); ?>',
                      <?php echo $r->getQuantidade(); ?>,
                      '<?php echo htmlspecialchars($r->getTipo(), ENT_QUOTES); ?>',
                      <?php echo $r->getPreco(); ?>
                    )"
                  >Editar</button>
                  <button type="button"
                    class="btn-excluir"
                    onclick="excluirRoupa(<?php echo $r->getId(); ?>)"
                  >Excluir</button>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
      <h3>Roupas Alugadas</h3>
<div class="alugadas" aria-live="polite">
  <?php foreach ($roupas as $r): ?>
    <?php if ($r->getStatus() == 'alugado'): ?>
      <div class="item" id="roupa-<?php echo $r->getId(); ?>">
        <h3><?php echo htmlspecialchars($r->getNome()); ?></h3>
        <p>Tamanho: <?php echo htmlspecialchars($r->getTamanho()); ?></p>
        <p>Preço: R$ <?php echo number_format($r->getPreco(), 2, ',', '.'); ?></p>
        <p>Quantidade: <?php echo htmlspecialchars($r->getQuantidade()); ?></p>
        <p>Tipo: <?php echo htmlspecialchars($r->getTipo()); ?></p>
        <div class="botoes-roupa">
          <button type="button"
            class="btn-devolver"
            onclick="devolverRoupa(<?php echo $r->getId(); ?>)"
          >Devolver</button>
        </div>
      </div>
    <?php endif; ?>
  <?php endforeach; ?>
</div>
    </section>

    <!-- Seção de Contato e Localização -->
    <section id="contato" class="contato-section" aria-labelledby="contato-titulo">
      <h2 id="contato-titulo">Localização &amp; Contato</h2>
      <div class="contato-info-wrapper">
        <div class="contato-info">
          <div>
            <p><strong>Endereço:</strong> Avenida Exemplo, 123 – Centro, Sua Cidade, SP 00000-000</p><br>
            <p><strong>Telefone:</strong> <a href="tel:+5511999999999">(11) 99999-9999</a></p><br>
            <p><strong>E-mail:</strong> <a href="mailto:contato@pegaeusa.com">contato@pegaeusa.com</a></p><br>
            <p><strong>Horário:</strong> Segunda a Sábado, das 9h às 18h</p>
          </div>
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3656.294808502569!2d-46.50534048927356!3d-23.593757778689024!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce67cd8504cb55%3A0x2fa2efa8b64460ed!2sSushi%20Imperador!5e0!3m2!1spt-BR!2sbr!4v1748754872663!5m2!1spt-BR!2sbr"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Mapa Pega e Usa"
            aria-label="Mapa Pega e Usa">
          </iframe>
        </div>
      </div>
      <div class="redes">
        <a href="https://wa.me/SEUNUMEROAQUI" target="_blank" aria-label="WhatsApp">
          <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" width="40" height="40" />
        </a>
        <a href="https://instagram.com/pegaeusa" target="_blank" aria-label="Instagram">
          <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" width="40" height="40" />
        </a>
      </div>
    </section>
    <button id="voltar-topo" aria-label="Voltar ao topo" title="Voltar ao topo">↑</button>
  </main>

  <!-- Modal Sobre Nós -->
  <div id="sobre-nos-modal" class="modal">
    <div class="modal-content">
      <button type="button" class="close-modal" id="close-sobre-nos" aria-label="Fechar">&times;</button>
      <h2>Sobre a Pega e Usa</h2>
      <p>
        A Pega e Usa nasceu para facilitar o aluguel de roupas para todas as ocasiões. Nossa missão é democratizar o acesso à moda, oferecendo praticidade, economia e sustentabilidade. Aqui, você encontra peças de qualidade, com variedade de estilos e tamanhos, prontas para serem usadas e devolvidas com facilidade.
      </p>
      <ul>
        <li>👚 Variedade de roupas para todos os estilos</li>
        <li>👟 Tênis, camisetas, ternos, calças e muito mais</li>
        <li>🔄 Processo de aluguel e devolução simples</li>
        <li>💙 Atendimento dedicado</li>
      </ul>
    </div>
  </div>

  <!-- Footer -->
  <footer role="contentinfo">
    <div class="footer-content">
      <div class="footer-logo">
        <span>Pega e Usa</span>
      </div>
      <div class="footer-links">
        <a href="#estoque">Estoque</a>
        <a href="#contato">Contato</a>
        <button id="sobre-nos-btn" class="sobre-nos-footer-btn">Sobre Nós</button>
        <a href="https://wa.me/SEUNUMEROAQUI" target="_blank" aria-label="WhatsApp" class="whatsapp-footer">
          <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" width="20" height="20" />
          WhatsApp
        </a>
        <a href="https://instagram.com/pegaeusa" target="_blank" aria-label="Instagram">
          <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" width="20" height="20" />
          Instagram
        </a>
      </div>
      <p>&copy; 2025 Pega e Usa. Criado por Felipe.</p>
    </div>
  </footer>
  <script src="script.js"></script>
</body>
</html>