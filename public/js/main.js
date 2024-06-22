
function showTab(tabName) {
    var tabs = document.getElementsByClassName('tab-content');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = 'none';
    }
    var tabLinks = document.getElementsByClassName('tab-link');
    for (var i = 0; i < tabLinks.length; i++) {
        tabLinks[i].classList.remove('active');
    }
    document.getElementById(tabName + '-tab').style.display = 'block';
    document.querySelector('.tab-nav a[href="#"][onclick="showTab(\'' + tabName + '\')"]').classList.add('active');
}

// General
document.getElementById("general-form").addEventListener("submit", async (event) => {
    event.preventDefault();

    const time = document.getElementById("time").value.trim();
    const slideTime = document.getElementById("slideTime").value.trim();
    const show = document.getElementById("show").value;

    console.log(show);

    const config = {
        time: time,
        slideTime: slideTime,
        show: show
    };

    console.log(config);  // Para verificar que el objeto tiene la estructura correcta

    try {
        const response = await fetch('../../config/configManager.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(config)
        });

        if (response.ok) {
            alert('Configuración guardada exitosamente.');
        } else {
            alert('Error al guardar la configuración.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Ocurrió un error al guardar la configuración.');
    }
});

document.querySelectorAll('.db-form').forEach(form => {
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(event.target);
        const preferDb = event.target.id.split('-')[0];
        const config = {
            prefer_db: preferDb,
        };

        formData.forEach((value, key) => {
            config[key] = value;
        });

        console.log(config);  // Para verificar que el objeto tiene la estructura correcta

        try {
            const response = await fetch('../../config/configManager.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(config)
            });

            if (response.ok) {
                alert('Configuración guardada exitosamente.');
            } else {
                alert('Error al guardar la configuración.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Ocurrió un error al guardar la configuración.');
        }
    });
});

let currentVisibleForm = null;

function showForm(dbType) {
    const forms = document.querySelectorAll('.db-form');
    const targetForm = document.getElementById(dbType + '-form');

    // If the clicked form is currently visible, hide it
    if (targetForm === currentVisibleForm) {
        targetForm.style.display = 'none';
        currentVisibleForm = null;
        return;
    }

    // Hide all forms
    forms.forEach(form => form.style.display = 'none');

    // Show the target form
    targetForm.style.display = 'block';
    currentVisibleForm = targetForm;
}

async function testConnection() {
    const loading = document.getElementById('loading');
    const resultDiv = document.getElementById('result');
    loading.style.display = 'block';
    resultDiv.innerHTML = '';

    try {
        const response = await fetch('../../controllers/controller.php?action=testConnection', {
            method: 'GET'
        });

        if (response.ok) {
            const result = await response.json();
            if (result.success) {
                resultDiv.innerHTML = `<p>${result.message}</p>`;
            } else {
                resultDiv.innerHTML = `<p>Connection failed: ${result.message}</p>`;
            }
        } else {
            resultDiv.innerHTML = '<p>Error al probar la conexión.</p>';
        }
    } catch (error) {
        console.error('Error:', error);
        resultDiv.innerHTML = '<p>Error al probar la conexión.</p>';
    } finally {
        loading.style.display = 'none';
    }
}

document.getElementById('test-command-form').addEventListener('submit', async (event) => {
    event.preventDefault();

    const barcode = document.getElementById('id-barcode').value.trim();
    const loading = document.getElementById('loading');
    const resultDiv = document.getElementById('test-command-result');
    loading.style.display = 'block';
    resultDiv.innerHTML = '';

    try {
        const response = await fetch('../../controllers/controller.php?action=query&id=' + barcode, {
            method: 'GET'
        });

        if (response.ok) {
            const result = await response.json();
            resultDiv.innerHTML = `<p>${JSON.stringify(result)}</p>`;
        } else {
            resultDiv.innerHTML = '<p>Error al probar el comando.</p>';
        }
    } catch (error) {
        console.error('Error:', error);
        resultDiv.innerHTML = '<p>Error al probar el comando.</p>';
    } finally {
        loading.style.display = 'none';
    }
});
