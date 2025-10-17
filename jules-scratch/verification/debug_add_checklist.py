from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    try:
        # Navigate to the add checklist page
        page.goto("http://localhost:8765/checklists/add")

        # Fill out the form
        page.fill("input[name='numero_ordem_producao']", "12345")
        page.fill("input[name='cliente']", "Test Client")
        page.select_option("select#data-carregamento-year", "2025")
        page.select_option("select#data-carregamento-month", "10")
        page.select_option("select#data-carregamento-day", "26")
        page.fill("input[name='destino']", "Test Destination")
        page.fill("input[name='voltagem']", "220V")
        page.fill("input[name='numero_serie']", "98765")
        page.select_option("select#maquina-id", "1")

        # Wait for the equipment to load
        page.wait_for_selector("#equipamentos-container input")

        # Submit the form
        page.click("button[type='submit']")

        # Wait for the page to load after submission
        page.wait_for_load_state()

    finally:
        browser.close()

with sync_playwright() as playwright:
    run(playwright)