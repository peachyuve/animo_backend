<div class="row">
  <div class="col-10 col-sm-6 mb-4 mb-md-0">
    <h1 id="header-title" class="header__title"></h1>
    <h4 id="header-date" class="header__date">
      <!-- date injected from js -->
      <span class="header__day">Kamis, </span>10 Juni 2021
    </h4>
  </div>
  <div class="col-2 col-sm-6">
    <div
      class="
        header__profile
        d-flex
        justify-content-center justify-content-md-end
        align-items-center
      "
    >
      <!-- two first char name will be injected by js -->
      <h2 id="header-abbr" class="header__abbr"> <?= session()->get('inisial') ?> </h2>
      <!-- need php injection for user name -->
      <h4 class="header__name d-none d-sm-block"> <?= session()->get('nama') ?> </h4>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="15"
        height="15"
        fill="currentColor"
        class="d-none d-sm-block"
        viewBox="0 0 16 16"
      >
        <path
          d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"
        />
      </svg>
    </div>
  </div>
</div>