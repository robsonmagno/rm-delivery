<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include "includes/header.php"; ?>    
    <title>RM Delivery - Pedidos</title>
    <style>
        .order-bg {
            background-color: #B0E0E6;
        }
    </style>
</head>

<?php include "includes/nav.php"; ?>

<script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.16.0/firebase-app.js";
    import { getAuth, onAuthStateChanged, signInWithEmailAndPassword, createUserWithEmailAndPassword, signInWithPopup, GoogleAuthProvider, FacebookAuthProvider  } from "https://www.gstatic.com/firebasejs/9.16.0/firebase-auth.js";
    import { getFirestore, collection, doc, addDoc, setDoc, getDocs, query, where, getDoc } from "https://www.gstatic.com/firebasejs/9.16.0/firebase-firestore.js"; 
    
    // Initialize Firebase
    const app = initializeApp(firebaseConfig);

    const auth = getAuth();
    onAuthStateChanged(auth, async (user) =>  {
        if (user) {
            // User is signed in, see docs for a list of available properties
            // https://firebase.google.com/docs/reference/js/firebase.User
            const uid = user.uid;

            // Initialize Cloud Firestore and get a reference to the service
            const db = getFirestore(app);
            const userRef =   doc(db, "users", "FkYzcbK7mZ7ZVArItp9G"); 
            //const docSnap = await getDoc(userRef);
            //console.log(docSnap.data());

            const ordersRef = collection(db, "orders");            
            const ordersQuery = query(ordersRef, where("uid", "==", userRef));
            const querySnapshot = await getDocs(ordersQuery);
            
            var html = '';
            querySnapshot.forEach( async (result) => {
                switch(result.data().order_status) {
                    case 10:
                        status = '<i class="fas fa-lg fa-check text-success"> Entregue</i>';
                        break;
                    case 20:
                        status = '<i class="fas fa-lg fa-truck text-primary"> Entregando</i>';
                        break;
                    case 80:
                        status = '<i class="fas fa-lg fa-undo text-warning"> Retornado</i>';
                        break;
                    case 90:
                        status = '<i class="fas fa-lg fa-times text-danger"> Cancelado</i>';
                        break;
                }
         
                const storeRef =  doc(db, "stores", result.data().store.id); 
                const storeSnap = await getDoc(storeRef);
                var store = storeSnap.data().store_name;

                var dateFormat = new Date(result.data().order_date.toDate())

                var date = dateFormat.getDate()+
                    "/"+(dateFormat.getMonth()+1)+
                    "/"+dateFormat.getFullYear()+
                    " "+dateFormat.getHours()+
                    ":"+dateFormat.getMinutes();


                html += '<div class="row text-dark order-bg list-group-item d-flex justify-content-between align-items-center p-3">';
                    html += '<div class="col-md-2"><b>'+result.data().order_number+'</b></div>';
                    html += '<div class="col-md-2"><b>'+date+'</b></div>';
                    html += '<div class="col-md-4"><b>'+store+'</b></div>';
                    html += '<div class="col-md-2"><b>R$ '+result.data().order_amount+'</b></div>';
                    html += '<div class="col-md-2">'+status+'</div>';
                html += '</div>';

                $("#orders").append(html);
                html = '';
            });
            
        }
    });
</script>

    <section>
        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4 mb-md-0">
                        <div class="card-body">
                            <p class="mb-4"><span class="text-primary font-italic me-1">Últimos Pedidos</span></p>
                            <div class="card-body p-0">
                                <div class="row bg-gradient-primary text-white">
                                    <div class="col-md-2">Número</div>
                                    <div class="col-md-2">Data</div>
                                    <div class="col-md-4">Loja</div>
                                    <div class="col-md-2">Valor</div>
                                    <div class="col-md-2">Status</div>
                                </div>
                                <ul class="list-group list-group-flush rounded-3" id="orders"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>                
<?php include "includes/footer.php"; ?>