/*
var canvas = document.getElementById('myCanvas');
var ctx = canvas.getContext('2d');
var balls = [];
var ballRadius = 30;
var img = new Image();
var imgs = [] 


function setImg(image){
       var ball = {
        x: Math.random() * (180 - 10) + 10,
        y: 20,
        r: ballRadius,
        vx: 0,
        vy: 12,
        falling: true,
        imgsrc:  ".." + image
      };
      balls.push(ball);
}

function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  for (var i = 0; i < balls.length; i++) {
    var ball = balls[i];
    var collision = 0;
   
    ctx.beginPath();
    img.src = ball.imgsrc 
   // ctx.drawImage(img, ball.x - ballRadius, ball.y - ballRadius, img.width*1.3, img.width*1.3);
    ctx.arc(ball.x, ball.y, ballRadius, 0, Math.PI * 2);
    ctx.fillStyle = "#c82124"; //red
    ctx.fill();
    ctx.closePath();

    for (var j = 0; j < balls.length; j++) {
        if(j != i) { if(detectCollision(ball, balls[j])) { if(balls[j].falling == false) collision++ } }; 
        if(j != i) { detectWallCollision(ball, canvas) }; 
    }
   
    if (ball.y + ballRadius < canvas.height) {
        if(collision < 2) {
        ball.y += ball.vy;
        ball.x += ball.vx;
         ball.vy += 0.1;
      } ball.falling = false;
    } else {
      ball.vy = -(ball.vy/2);
    }
  }
  requestAnimationFrame(draw);
}

draw();

  function detectCollision(ball1, ball2) {
    var collides = false;
    var dx = ball1.x - ball2.x;
    var dy = ball1.y - ball2.y;
    var distance = Math.sqrt(dx * dx + dy * dy);

    if (distance < ball1.r + ball2.r) {
        collides = true;
        var angle = Math.atan2(ball1.y - ball2.y, ball1.x - ball2.x);

        ball1.vx = Math.cos(angle);
        ball1.vy = Math.sin(angle);
        ball1.vx *= 0.5;
        ball1.vy *= 0.5;
    }
    return collides;
}


function detectWallCollision(ball, canvas) {
  if (ball.x - ball.r < 0 - ball.r || ball.x + ball.r > canvas.width + ball.r) {
    ball.vx = -ball.vx;
  }
}
*/

function removeOne() {
    balls.pop();
    balls.pop();
    sessionStorage.setItem("zutatenArray", JSON.stringify(balls));
}
function removeSpecificOne(image) {
    var count = 0;
    for (var i = 0; i < balls.length; i++) {
      if (balls[i].img === "../images/" + image) {
        balls.splice(i, 1);
        count++;
        i--;
        if (count === 2) {
          break;
        }
      }
    }
    
    sessionStorage.setItem("zutatenArray", JSON.stringify(balls));
}

function removeSpecificAll(image) {
	var newBalls = []
    for (var i = 0; i < balls.length; i++) {
        if (balls[i].img !== "../images/" + image) {
            newBalls.push(balls[i])
        }
    }
	balls = newBalls;
    sessionStorage.setItem("zutatenArray", JSON.stringify(balls));
}

function removeAll() {
    balls = [];
    sessionStorage.setItem("zutatenArray", JSON.stringify(balls));
}

function Ball(x, y, radius, e, mass, image) {
    this.position = { x: x, y: y }; //m
    this.velocity = { x: 0, y: 0 }; // m/s
    this.e = -e; // has no units
    this.mass = mass; //kg
    this.radius = radius; //m
    this.area = (Math.PI * radius * radius) / 100; //m^2
    this.img = "../images/" + image;
}
var canvas = null;
var ctx = null;
var fps = 1 / 60; //60 FPS
var dt = fps * 1000; //ms
var timer = false;
var Cd = 0.47;
var rho = 1.22; //kg/m^3
var mouse = { x: 0, y: 0, isDown: false };
var ag = 9.81; //m/s^2 acceleration due to gravity on earth = 9.81 m/s^2.
var width = 0;
var height = 0;
var balls = [];
var img = new Image();

function setImg(image, count) {
    for (let i = 0; i < count * 3; i++) {
        balls.push(
            new Ball(Math.random() * (265 - 0) + 0, 50, 15, 0.7, 10, image)
        );
    }
	sessionStorage.setItem("zutatenArray", JSON.stringify(balls));
}

var setup = function () {
    canvas = document.getElementById("myCanvas");
    ctx = canvas.getContext("2d");
    width = canvas.width;
    height = canvas.height;
    timer = setInterval(loop, dt);
    if (JSON.parse(sessionStorage.getItem("zutatenArray"))) {
        balls = JSON.parse(sessionStorage.getItem("zutatenArray"));
    }
};

function loop() {
    //create constants
    var gravity = 1;
    var density = 1.22;
    var drag = 0.47;

    //Clear window at the begining of every frame
    ctx.clearRect(0, 0, width, height);
    for (var i = 0; i < balls.length; i++) {
        if (!mouse.isDown || i != balls.length - 1) {
            //physics - calculating the aerodynamic forces to drag
            // -0.5 * Cd * A * v^2 * rho
            var fx =
                -0.5 *
                drag *
                density *
                balls[i].area *
                balls[i].velocity.x *
                balls[i].velocity.x *
                (balls[i].velocity.x / Math.abs(balls[i].velocity.x));
            var fy =
                -0.5 *
                drag *
                density *
                balls[i].area *
                balls[i].velocity.y *
                balls[i].velocity.y *
                (balls[i].velocity.y / Math.abs(balls[i].velocity.y));

            fx = isNaN(fx) ? 0 : fx;
            fy = isNaN(fy) ? 0 : fy;
            //Calculating the accleration of the ball
            //F = ma or a = F/m
            var ax = fx / balls[i].mass;
            var ay = ag * gravity + fy / balls[i].mass;

            //Calculating the ball velocity
            balls[i].velocity.x += ax * fps;
            balls[i].velocity.y += ay * fps;

            //Calculating the position of the ball
            balls[i].position.x += balls[i].velocity.x * fps * 100;
            balls[i].position.y += balls[i].velocity.y * fps * 100;
        }
        var img = new Image();
        //Rendering the ball
        img.src = balls[i].img;
        ctx.beginPath();

        ctx.drawImage(
            img,
            balls[i].position.x - balls[i].radius * 1.35,
            balls[i].position.y - balls[i].radius * 1.35,
            45, 45

        );
        //ctx.arc(balls[i].position.x, balls[i].position.y, balls[i].radius, 0, 2 * Math.PI, true);
        //ctx.fill();
        ctx.closePath();

        //Handling the ball collisions
        collisionBall(balls[i]);
        collisionWall(balls[i]);
        sessionStorage.setItem("zutatenArray", JSON.stringify(balls));
    }
}

function collisionWall(ball) {
    if (ball.position.x > width - ball.radius) {
        ball.velocity.x *= ball.e;
        ball.position.x = width - ball.radius;
    }
    if (ball.position.y > height - ball.radius) {
        ball.velocity.y *= ball.e;
        ball.position.y = height - ball.radius;
    }
    if (ball.position.x < ball.radius) {
        ball.velocity.x *= ball.e;
        ball.position.x = ball.radius;
    }
    if (ball.position.y < ball.radius) {
        ball.velocity.y *= ball.e;
        ball.position.y = ball.radius;
    }
}
function collisionBall(b1) {
    for (var i = 0; i < balls.length; i++) {
        var b2 = balls[i];
        if (b1.position.x != b2.position.x && b1.position.y != b2.position.y) {
            //quick check for potential collisions using AABBs
            if (
                b1.position.x + b1.radius + b2.radius > b2.position.x &&
                b1.position.x < b2.position.x + b1.radius + b2.radius &&
                b1.position.y + b1.radius + b2.radius > b2.position.y &&
                b1.position.y < b2.position.y + b1.radius + b2.radius
            ) {
                //pythagoras
                var distX = b1.position.x - b2.position.x;
                var distY = b1.position.y - b2.position.y;
                var d = Math.sqrt(distX * distX + distY * distY);

                //checking circle vs circle collision
                if (d < b1.radius + b2.radius) {
                    var nx = (b2.position.x - b1.position.x) / d;
                    var ny = (b2.position.y - b1.position.y) / d;
                    var p =
                        (2 *
                            (b1.velocity.x * nx +
                                b1.velocity.y * ny -
                                b2.velocity.x * nx -
                                b2.velocity.y * ny)) /
                        (b1.mass + b2.mass);

                    // calulating the point of collision
                    var colPointX =
                        (b1.position.x * b2.radius +
                            b2.position.x * b1.radius) /
                        (b1.radius + b2.radius);
                    var colPointY =
                        (b1.position.y * b2.radius +
                            b2.position.y * b1.radius) /
                        (b1.radius + b2.radius);

                    //stoping overlap
                    b1.position.x =
                        colPointX +
                        (b1.radius * (b1.position.x - b2.position.x)) / d;
                    b1.position.y =
                        colPointY +
                        (b1.radius * (b1.position.y - b2.position.y)) / d;
                    b2.position.x =
                        colPointX +
                        (b2.radius * (b2.position.x - b1.position.x)) / d;
                    b2.position.y =
                        colPointY +
                        (b2.radius * (b2.position.y - b1.position.y)) / d;

                    //updating velocity to reflect collision
                    b1.velocity.x -= p * b1.mass * nx;
                    b1.velocity.y -= p * b1.mass * ny;
                    b2.velocity.x += p * b2.mass * nx;
                    b2.velocity.y += p * b2.mass * ny;
                }
            }
        }
    }
}
