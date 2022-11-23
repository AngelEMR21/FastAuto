<?php
    require 'includes/funciones.php';    
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Nuestro Blog</h1>

        <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <!-- <source srcset="build/img/blog1.webp" type="image/webp">
                        <source srcset="build/img/blog1.jpg" type="image/jpeg"> -->
                        <img loading="lazy" src="build/img/ferrari.jpg" alt="Texto Entrada Blog">
                    </picture>
                </div>

                <div class="texto-entrada">
                    <a href="entrada.php">
                        <h4>Conoce el modelo de Ferrari más barato del mundo</h4>
                        <p class="informacion-meta">Escrito el: <span>20/10/2022</span> por: <span>Admin</span> </p>

                        <p>
                        Olvidado por muchos, despreciado por otros, el Ferrari Mondial es hoy por hoy el modelo de la marca italiana más accesible, aunque no para cualquier bolsillo
                        </p>
                    </a>
                </div>
            </article>

            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <!-- <source srcset="build/img/blog2.webp" type="image/webp"> -->
                        <!-- <source srcset="build/img/blog2.jpg" type="image/jpeg"> -->
                        <img loading="lazy" src="build/img/Noticia.png" alt="Texto Entrada Blog">
                    </picture>
                </div>

                <div class="texto-entrada">
                    <a href="entrada.php">
                        <h4>Autos a hidrógeno, ¿serán una alternativa viable?</h4>
                        <p class="informacion-meta">Escrito el: <span>20/10/2022</span> por: <span>Admin</span> </p>

                        <p>
                        Ante la desaparición inminente de los autos de combustión interna y la limitada autonomía de los autos eléctricos, los autos a hidrógeno surgen como alternativa
                        </p>
                    </a>
                </div>
            </article>
            
    </main>

<?php
    incluirTemplate('footer');
?>