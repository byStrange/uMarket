var popupIndex = 0;
var relatedWindows = [];

var input = document.getElementById("categorytranslation-language_code")
function fire(win, object_id, repr) {
  const name = removePopupIndex(win.name);
  const elem = document.getElementById(name)
  if (elem) {
    if (elem.nodeName === 'SELECT') {
      var option = document.createElement('option')
      option.value = object_id;
      option.innerText = repr;
      option.selected = true;
      elem.appendChild(option)
    }
  }
  console.log(name)
  //input.value = 12
  //
  console.log(win, object_id, repr)
  win.close();
}

// popup will be created, its name is gonna be field name, and when popup gets response from server, it calls parent function with win, and new product details
function addPopupIndex(name) {
        return name + "__" + (popupIndex + 1);
    }

function removePopupIndex(name) {
    return name.replace(new RegExp("__" + (popupIndex + 1) + "$"), '');
}

function showAdminPopup(triggeringLink, name_regexp, add_popup) {
  console.log(triggeringLink)
    const name = addPopupIndex(triggeringLink.id.replace(name_regexp, ''));
    const href = new URL(triggeringLink.href);
    if (add_popup) {
        href.searchParams.set('_popup', 1);
    }
    const win = window.open(href, name, 'height=500,width=800,resizable=yes,scrollbars=yes');
    win.opener = window
    relatedWindows.push(win);
    win.focus();
    return false;
}

function showRelatedObjectPopup(triggeringLink) {
    return showAdminPopup(triggeringLink, /^(change|add|delete)-/, false);
}

$('a[data-popup]').on('click',  (event) => {
  event.preventDefault();
  showRelatedObjectPopup(event.currentTarget)
})
