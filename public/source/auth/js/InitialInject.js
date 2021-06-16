const sidebarUrl = './common/sidebar.html';
const headUrl = './common/head.html';
const headerUrl = './common/header.html';
const constructionUrl = './common/underConstruction.html';

const sidebar = document.getElementById("sidebar");
const header = document.getElementById("header");
const head = document.head;
const page = head.dataset.title;
const fullName = localStorage.getItem("business");

completeTheHeadTag();
underConstruction();
if(sidebar) addSidebar();
if(header) addHeader();

async function addSidebar(){
  const response = await fetch(sidebarUrl);
  const html = await response.text();
  sidebar.innerHTML = html;
  sidebar.querySelectorAll(".sidebar__nav-menu").forEach(el=>{
    if(el.querySelector("span").textContent === page){
      // add active style
      el.classList.add("active");
      // turn off the anchor functionality
      el.style.pointerEvents = "none";
      el.style.cursor = "default";
    }
  })
  localStorage.setItem("name",fullName);
  sidebar.querySelector("#exit").addEventListener("click",()=>{
    exit();
  })
  
}

async function addHeader(){
  const response = await fetch(headerUrl);
  const html = await response.text();
  header.innerHTML = html;
  const headerTitle = header.querySelector("#header-title");
  const headerDate = header.querySelector("#header-date");
  const headerShort = header.querySelector("#header-shortname");
  const headerUname = header.querySelector("#header-username");
  const twoWordsName = fullName.trim().split(" ",2).join(" ");
  const firstChar = fullName.trim().split(" ",2).map(word=>{
    return word.substring(0,1).toLowerCase();
  })
  const now = new Date().toLocaleDateString('id-ID',{ weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
  headerTitle.textContent = page;
  headerShort.textContent = firstChar[0]+(firstChar[1]||"");
  headerUname.textContent = twoWordsName;
  headerDate.innerHTML = now.split(" ",1).join();
  headerDate.nextElementSibling.textContent = now.substr(now.indexOf(" ")+1);

  header.querySelector(".header__profile").addEventListener("click",()=>{
    header.querySelector(".header__cta").classList.toggle("show");
  })

  header.querySelector("#exit").addEventListener("click",()=>{
    exit();
  })
}

function exit(){
  localStorage.removeItem("business");
  localStorage.removeItem("selectedProduct");
}

async function completeTheHeadTag(){
  const response = await fetch(headUrl);
  const html = await response.text();
  head.insertAdjacentHTML("afterbegin",html);
  head.querySelector("title").textContent = page;
}

async function underConstruction(){
  const renov = document.getElementById("renovation") || false;
  if(renov){
    const response = await fetch(constructionUrl);
    const html = await response.text();
    renov.innerHTML = html;
    renov.querySelector("h2").textContent = "maaf, halaman "+page+" sedang dalam perbaikan";
    // remove all element's sibling
    let ns = renov.nextElementSibling;
    while(ns){
      let next = ns.nextElementSibling;
      renov.parentElement.removeChild(ns);
      ns = next;
    }
    
  }
}