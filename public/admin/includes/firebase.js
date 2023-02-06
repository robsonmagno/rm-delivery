// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyDhSTKWpQsmZcR9i8nx6a-SJdC2j4K7OBs",
  authDomain: "rm-delivery-1536a.firebaseapp.com",
  projectId: "rm-delivery-1536a",
  storageBucket: "rm-delivery-1536a.appspot.com",
  messagingSenderId: "623103770562",
  appId: "1:623103770562:web:d98832f1ee5570ca6de05b"
};

function setCookie(cname, cvalue, exdays) {
  alert(cvalue);
  const d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  let expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
      c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
      }
  }
  return "";
}






