
    import * as THREE from 'three';
    import {OrbitControls} from "three/examples/jsm/controls/OrbitControls";

    const three = document.querySelector('#three');

    let camera, 
        scene, 
        renderer,
        geometry,
        material,
        mesh,
        controls;

    let init = function() {
    scene = new THREE.Scene();
    /*  scene.background = new THREE.Color("hsl(200, 6%, 10%)"); */
        camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 2000);

        renderer = new THREE.WebGLRenderer({antialias: true, alpha: true});
        renderer.setClearColor( 0xffffff, 0 );
        renderer.setSize((window.innerWidth), (window.innerHeight));

        three.appendChild(renderer.domElement);

        camera.position.set(0,0,800);

        geometry = new THREE.SphereGeometry(300, 15, 10);
    
    
        material = new THREE.MeshBasicMaterial({ 
        color: 0x52CBA1, 
        wireframe: true, 
        wireframeLinewidth: 2
    });
        mesh = new THREE.Mesh(geometry, material);

        scene.add(mesh);

        controls = new OrbitControls( camera, renderer.domElement );
        controls.update();
    }

    let animate = function() {
        requestAnimationFrame(animate);

        mesh.rotation.x += 0.003;
        mesh.rotation.y += 0.003;
        controls.update();

        renderer.render(scene, camera);
    }

    if(document.querySelector('#three')){
       init();
        animate(); 
    }
    