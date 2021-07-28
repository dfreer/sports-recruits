window.onload = function () {
    const buttons = document.querySelectorAll('.trigger')
    buttons.forEach(link => {
        link.addEventListener('click', (event) => {
            const active = event.target
            const view = active.dataset.target

            // reset nav
            buttons.forEach(link => {
                link.classList.remove('active')
            })
            active.classList.add('active')

            // reset views
            document.querySelectorAll('.toggle')
                .forEach(el => {
                    if (el.classList.contains(`view-${view}`)) {
                        el.classList.remove('hidden')
                    }
                    else el.classList.add('hidden')
                })

        })
    })

    buttons[0].click()

};

