import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('three-container');
    if (!container) return;

    // Scene, Camera, Renderer
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(
        45,
        container.clientWidth / container.clientHeight,
        0.1,
        1000
    );
    camera.position.set(0, 1.2, 6);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.shadowMap.enabled = true;
    container.appendChild(renderer.domElement);

    // Lights
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.8);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 1.5);
    directionalLight.position.set(2, 4, 3);
    directionalLight.castShadow = true;
    scene.add(directionalLight);

    const fillLight = new THREE.PointLight(0xffffff, 0.3);
    fillLight.position.set(-2, 2, -2);
    scene.add(fillLight);

    // Ground plane (soft shadow reflection)
    const groundGeo = new THREE.PlaneGeometry(20, 20);
    const groundMat = new THREE.ShadowMaterial({ opacity: 0.2 });
    const ground = new THREE.Mesh(groundGeo, groundMat);
    ground.rotation.x = -Math.PI / 2;
    ground.position.y = -0.5;
    ground.receiveShadow = true;
    scene.add(ground);

    // 🔹 Load 3D Model Porsche
    const loader = new GLTFLoader();
    loader.load(
    '/Models/landing/scene.gltf',
    (gltf) => {
        const model = gltf.scene;
        scene.add(model);

        // Hitung ukuran asli model
        const box = new THREE.Box3().setFromObject(model);
        const size = new THREE.Vector3();
        box.getSize(size);
        const center = new THREE.Vector3();
        box.getCenter(center);

        // Normalisasi ukuran model agar pas ke layar
        const maxDim = Math.max(size.x, size.y, size.z);
        const scale = 2.5 / maxDim; // semakin kecil = zoom lebih dekat
        model.scale.setScalar(scale);
        model.position.sub(center.multiplyScalar(scale)); // pusatkan

        // Optional: tambahkan sedikit elevasi

        // Rotasi idle
        const animate = () => {
            requestAnimationFrame(animate);
            model.rotation.y += 0.005;
            controls.update();
            renderer.render(scene, camera);
        };
        animate();
    },
    undefined,
    (error) => console.error('Error loading model:', error)
);


    // Controls
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.minDistance = 2;
    controls.maxDistance = 4;
    controls.target.set(0, 0.2, 0);
    controls.update();

    // Resize
    window.addEventListener('resize', () => {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    });
});
