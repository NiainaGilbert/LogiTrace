document.addEventListener("DOMContentLoaded", ()=>
{
        let links = document.querySelectorAll("[data-page]");
        let main = document.getElementById("main-content");
        links.forEach(
            link => 
            {
                link.addEventListener("click", ()=>
                    {
                        let page = link.dataset.page;
                        links.forEach(l=>
                            {
                                l.classList.remove('active')
                            })
                        link.classList.add('active');
                        fetch('pages/' + page + '.php')
                        .then(res => res.text())
                        .then(data => {
                            main.innerHTML = data;
                        });

                    });
            }
    )
});

