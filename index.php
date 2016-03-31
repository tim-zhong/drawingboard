<!DOCTYPE html>
<html>
<body>
<style>
* {margin: 0; padding: 0;}
body {background: #17293a;}
canvas {display: block;}
</style>

<span id="boardid"></span><br/>
<canvas></canvas>


<script src="wss/wss.js"></script>
<script>

// var originalleft = window.innerWidth/2;
// var originaltop = window.innerHeight/2;

var originalleft =window.innerWidth/2;
var originaltop = window.innerHeight/2;

var originalalpha = 0;
var originalbeta = 0;

var speed = 1;

var currentleft = 600;
var currenttop = 600;

var socket = null;
var url = "ws://ec2-52-37-132-185.us-west-2.compute.amazonaws.com:9697";
socket = wssconnect(socket,url,'board');

var myx=0;
var myy=0;



(function() {
  'use strict';
  // Declare us some global vars
  var canvas, ctx, width, height, mouseParticles, followingParticles, mouse, numParticles, colors;

  // Generic Particle constructor
  function Particle(x, y, radius, color) {
    this.x = x;
    this.y = y;
    this.radius = radius;
    this.color = color;
    this.speed = 0.2 + Math.random() * 0.02;
    this.offset = -25 + Math.random() * 50;
    this.angle = Math.random() * 360;
    this.targetX = null;
    this.targetY = null;
    this.vx = null;
    this.vy = null;
    this.compositeOperation = 'source-over';
  }

  Particle.prototype = {
    constructor: Particle,
    draw: function(ctx) {
      ctx.save();
      
      ctx.fillStyle = this.color;
      ctx.translate(this.x, this.y);
      ctx.beginPath();
      ctx.arc(0, 0, this.radius, 0, Math.PI * 2, true);
      ctx.closePath();
      ctx.fill();
      ctx.restore();
    }
  }

  init(); // Start the program
  function init() {
    // Assign global vars accordingly
    canvas = document.querySelector('canvas');
    ctx = canvas.getContext('2d');
    width = canvas.width = window.innerWidth;
    height = canvas.height = window.innerHeight;
    // Get mouse positions
    // Two arrays to hold our rotating and 'following' particles
    mouseParticles = [];
    followingParticles = [];
    numParticles = 3;
    colors = ['#e74509', '#243d89', '#ffe500'];

    // Generate particles to rotate our mouse
    generateParticles(mouseParticles, numParticles, 0, 0);

    // Generate particles, which follow the mouse particles
    generateParticles(followingParticles, numParticles, Math.random() * width, Math.random() * height);

    drawFrame();

  }

  // Generic function for generating particles
  function generateParticles(particlesArray, count, x, y) {
    var i, particle;
    for (i = 0; i < count; i++) {
      if (particlesArray === followingParticles) {
        particle = new Particle(x, y, 2, colors[i]);
      } else {
        particle = new Particle(x, y, 2,colors[i]);
      }
      particlesArray.push(particle);
    }
  }

  function drawFrame() {
    // Update & Redraw the entire screen on each frame
    window.requestAnimationFrame(drawFrame, canvas);
    ctx.fillStyle = 'rgba(23, 41, 58, 0.0)';
    ctx.fillRect(0, 0, width, height);
    mouseParticles.forEach(rotateParticle);
    followingParticles.forEach(updateParticle)
  }

  // Update each of our following particles to follow the corresponding rotating one
  function updateParticle(particle, index) {
    var rotParticle, speed, gravity,
        dx, dy, dist;

    rotParticle = mouseParticles[index];
    speed = 0.1;
    gravity = 0.8;


    particle.targetX = rotParticle.x;
    particle.targetY = rotParticle.y;

    dx = particle.targetX - particle.x;
    dy = particle.targetY - particle.y;
    dist = Math.sqrt(dx * dx + dy * dy);

    if (dist < 50) {
      particle.targetX = rotParticle.x;
      particle.targetY = rotParticle.y;
    } else {
      particle.targetX = mouseParticles[Math.round(index / 2)];
      particle.targetX = mouseParticles[Math.round(index / 2)];
    }

    particle.vx += dx * speed;
    particle.vy += dy * speed;
    particle.vx *= gravity;
    particle.vy *= gravity;
    particle.x += particle.vx;
    particle.y += particle.vy;

    particle.draw(ctx);
  }

  // Rotate our particles around the mouse one by one
  function rotateParticle(particle)  {
    var vr, radius, centerX, centerY;

    vr = 0.1;
    radius = width / 100;
    centerX = myx;
    centerY = myy;

    // Rotate the particles
    particle.x = centerX + particle.offset + Math.cos(particle.angle) * radius;
    particle.y = centerY + particle.offset + Math.sin(particle.angle) * radius;
    particle.angle += particle.speed;


    // Reposition a particle if it goes out of screen
    if (particle.x - particle.radius / 2 <= -radius / 2) {
      particle.x = 5;
    } else if (particle.x + particle.radius / 2 >= width - radius / 2) {
      particle.x = width - 5;
    } else if (particle.y - particle.radius / 2 <= -radius / 2) {
      particle.y = 5;
    } else if (particle.y + particle.radius / 2 >= height - radius / 2) {
      particle.y = height - 5;
    }

    //particle.draw(ctx);
  }


}());


</script>

</body>
</html>

<!-- <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<style>
span{font-size:40px;}

#test_square{display: block; position: absolute; top:100px; left:100px; background: #dedede; width:50px; height:50px;}
</style>
<span id="boardid"></span><br/>
<span id="ax"></span><br/>
<span id="ay"></span><br/>
<span id="az"></span><br/>
<span id="arAlpha"></span><br/>
<span id="arBeta"></span><br/>
<span id="arGamma"></span><br/>
<span id="alpha"></span><br/>
<span id="beta"></span><br/>
<span id="gamma"></span><br/>

<div id="test_square">
</div>

<script src="wss/wss.js"></script>
<script>
var originalleft = window.innerWidth/2;
var originaltop = window.innerHeight/2;

var originalalpha = 0;
var originalbeta = 0;

var speed = 6;

var currentleft = 600;
var currenttop = 600;

var socket = null;
var url = "ws://ec2-52-37-132-185.us-west-2.compute.amazonaws.com:9697";
socket = wssconnect(socket,url,'board');

</script>	
</body>
</html> -->
