from playwright.sync_api import sync_playwright, Page, expect

def run(page: Page):
    # Navegar para a página de adição
    page.goto("http://localhost:8765/checklists/add")

    # Preencher o formulário
    page.get_by_label("Numero Ordem Producao").fill("OP-VERIFICACAO")
    page.get_by_label("Cliente").fill("Cliente Frontend")
    page.get_by_label("Destino").fill("Destino Frontend")

    # Selecionar a máquina
    page.locator('#maquina-id').select_option(label="VIBRO PRENSA AUTOMÁTICA DE BLOCO HTX 900")

    # Esperar que o texto do primeiro equipamento apareça
    expect(page.get_by_text("CORPO DA FORMA")).to_be_visible()

    # Tirar a screenshot
    page.screenshot(path="jules-scratch/verification/verification.png")

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    page = browser.new_page()
    run(page)
    browser.close()