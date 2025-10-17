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

        # Navigate to the generated PDF
        # We need to get the ID of the created checklist
        # The easiest way is to go to the index page and get the ID of the first checklist
        page.goto("http://localhost:8765/checklists")
        first_checklist_link = page.locator("a:has-text('View')").first
        href = first_checklist_link.get_attribute("href")
        checklist_id = href.split("/")[-1]

        page.goto(f"http://localhost:8765/checklists/generate-pdf/{checklist_id}")

        # Take a screenshot
        page.screenshot(path="jules-scratch/verification/verification.png")

    finally:
        browser.close()

with sync_playwright() as playwright:
    run(playwright)