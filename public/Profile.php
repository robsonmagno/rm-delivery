<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>RM Delivery - Conta</title>
    <?php include "includes/header.php"; ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
</head>

<?php include "includes/nav.php"; ?>

    <script type="module">
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "https://www.gstatic.com/firebasejs/9.16.0/firebase-app.js";
        import { getAuth, onAuthStateChanged, signInWithEmailAndPassword, createUserWithEmailAndPassword, signInWithPopup, GoogleAuthProvider, FacebookAuthProvider  } from "https://www.gstatic.com/firebasejs/9.16.0/firebase-auth.js";
        import { getFirestore, collection, doc, addDoc, setDoc, getDocs, query, where } from "https://www.gstatic.com/firebasejs/9.16.0/firebase-firestore.js"; 
        
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
                const usersRef = collection(db, "users");

                const stateQuery = query(usersRef, where("uid", "==", uid));

                const querySnapshot = await getDocs(stateQuery);

                querySnapshot.forEach((doc) => {
                    if(uid!="") {
                        var user_email = doc.data().user_email;
                        var user_name = doc.data().user_name;
                        var user_phone = doc.data().user_phone;
                        var user_address = doc.data().user_address;
                        
                        $("#user_name").val(user_name);
                        $("#user_email").html(user_email);
                        $("#user_phone").val(user_phone);
                        $(".user_address").html(user_address);
                        $("#user_address").val(user_address);
                    }            
                });
            }
        });

        
        getLocation();
        
    </script>
    
    <section>
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img id="user_foto" alt="avatar" class="rounded-circle img-fluid user_foto" style="width: 150px;">
                            <h5 class="my-3 user_name"></h5>
                            <!--<p class="text-muted mb-1">Full Stack Developer</p>-->
                            <p class="text-muted mb-4 user_address"></p>
                            <div class="d-flex justify-content-center mb-2">
                                <button type="button" class="btn btn-outline-primary ms-1">Mensagem</button>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <div id="geolocationMap" style="width: 100%; height: 400px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Nome</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-user" id="user_name" name="user_name" placeholder="Nome">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0" id="user_email"></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Telefone</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-user" id="user_phone" name="user_phone" placeholder="Telefone">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Endereço</p>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-user" id="user_address" name="user_address" placeholder="Endereço">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-9"></div>
                                <div class="col-sm-3">
                                    <input type="button" class="form-control btn btn-primary" id="profileSave" name="profileSave" value="Salvar">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                    <div class="card-body p-0">
                                        <div class="my-4">
                                            <h5 class="mb-0">Notificações</h5>
                                            <p>Selecione as notificações que deseja receber</p>
                                            <hr class="my-4" />
                                            <strong class="mb-0">Pedidos</strong>
                                            <p>Atualização do Pedido</p>
                                            <div class="list-group mb-5 shadow">
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <strong class="mb-0">Notificação</strong>
                                                            <p class="text-muted mb-0">Receber Notificações quando seu pedido mudar de status</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <input type="checkbox" data-toggle="switchbutton" checked data-width="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <strong class="mb-0">Email</strong>
                                                            <p class="text-muted mb-0">Receber emails quando seu pedido mudar de status</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <input type="checkbox" data-toggle="switchbutton" checked data-width="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <strong class="mb-0">Mensagens</strong>
                                                            <p class="text-muted mb-0">Receber mensagem quando seu pedido mudar de status</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <input type="checkbox" data-toggle="switchbutton" checked data-width="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-4" />
                                            <strong class="mb-0">Informações</strong>
                                            <p>Selecione onde quer receber informações sobre promoções, descontos e atualizações</p>
                                            <div class="list-group mb-5 shadow">
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <strong class="mb-0">Notificação</strong>
                                                            <p class="text-muted mb-0">Receber Notificações sobre promoções, descontos e atualizações</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <input type="checkbox" data-toggle="switchbutton" checked data-width="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <strong class="mb-0">Email</strong>
                                                            <p class="text-muted mb-0">Receber emails sobre promoções, descontos e atualizações</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <input type="checkbox" data-toggle="switchbutton" checked data-width="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <strong class="mb-0">Mensagem</strong>
                                                            <p class="text-muted mb-0">Receber mensagens sobre promoções, descontos e atualizações</p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <input type="checkbox" data-toggle="switchbutton" checked data-width="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include "includes/footer.php"; ?>

<script>
    var x = document.getElementById("geolocationPosition");

    function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
    }

    function showPosition(position) {
        const map = L.map('geolocationMap').setView([position.coords.latitude, position.coords.longitude], 13);

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        const marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
    }
</script>