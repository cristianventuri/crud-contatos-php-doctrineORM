<nav  class="navbar navbar-expand-lg bg-body-tertiary nav-principal">
  <ul>
    <li class="container-md">
      <a href="/" class="nav-index">Home</a>
    </li>
    <li class="container-md">
      <a href="/pessoa" class="nav-pessoa">Pessoa</a>
    </li>
    <li class="container-md">
      <a href="/contato" class="nav-contato">Contato</a>
    </li>
  </ul>
</nav>

<style>
  .nav-principal {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
  }

  .nav-principal ul {
    display: flex;
    list-style: none;
    background-color: #35363a;
    margin: 0;
    padding: 0;
    border: 1px solid #35363a;
    border-radius: 0.5rem;
    overflow: hidden;
  }

  .nav-principal ul li:not(li:last-child) {
    border-right: 1px solid white;
  }

  .nav-principal ul li:hover {
    background-color: white;
  }

  .nav-principal ul li:hover a {
    color: black;
  }

  .nav-principal ul li a {
    padding: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 10rem;
    color: white;
    text-decoration: none;
  }
</style>