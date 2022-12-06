// Get the modal
let backGroundModal = document.getElementsByClassName("backGroundModal")[0];

function setLanguage() {
    let val = document.getElementById('menuBtnLan').textContent;
    let txt = "<span>"+val+"</span>";
    txt += '<form class="formModal" action="index.php" method="POST">';
    lanData.forEach(element => {
        txt += '<button type="submit" name="defLanID" value="'+element.id+'">'+element.name+'</button>'; 
    });
    txt += '</form>';
    openModal(txt);
}

function openMenu() {
    if(typeof defDirMenu !== 'undefined'){
        document.getElementById("myDropdown").style.cssText = 'display: block;' + defDirMenu;
    } else {
        document.getElementById("myDropdown").style.cssText = 'display: block;';
    }
}

// When the user clicks the button, open the modal 
function openModal(txt) {
    backGroundModal.style.display = "block";
    document.getElementById('textModal').innerHTML = txt;
}

// When the user clicks on <span> (x), close the modal
function closeByX() {
    backGroundModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
function closeModal(event) {
    if (event.target == backGroundModal) {
        backGroundModal.style.display = "none";
    }
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        let dropdowns = document.getElementsByClassName("dropdown-content");
        for (let i = 0; i < dropdowns.length; i++) {
            let openDropdown = dropdowns[i];
            openDropdown.style.cssText = 'display: none';
            // if (openDropdown.classList.contains('show')) {
            //     openDropdown.classList.remove('show');
            // }
        }
    }
}