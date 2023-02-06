var canvas = document.getElementById('myCanvas');
var ctx = canvas.getContext('2d');
var balls = [];
var ballRadius = 30;
var img = new Image();
var imgs = [] 


function setImg(image){
    var ball = {
        x: Math.random() * (canvas.width - ballRadius*2) + ballRadius,
        y: 20,
        r: ballRadius,
        vx: 0,
        vy: 3,
        imgsrc:  ".." + image
      };
      console.log(ball.x)
      balls.push(ball);
      draw();
}

function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  for (var i = 0; i < balls.length; i++) {
    var ball = balls[i];
    var collision = 0;
   
    ctx.beginPath();
    img.src = ball.imgsrc 
    ctx.drawImage(img, ball.x - ballRadius, ball.y - ballRadius, img.width*1.3, img.width*1.3);
    ctx.arc(ball.x, ball.y, ballRadius, 0, Math.PI * 2);
    ctx.closePath();

    for (var j = 0; j < balls.length; j++) {
        if(j != i) if(detectCollision(ball, balls[j])) collision++; 
        if(j != i) if(detectWallCollision(ball, canvas)) collision++; 
    }
   
    if (ball.y + ballRadius < canvas.height) {
        if(collision < 2) {
        ball.y += ball.vy;
        ball.x += ball.vx;

        if(ball.vy < 3) {
            ball.vy += 1;
        }
    }
    } else {
        ball.vx = 0;
        ball.vy = 0;

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
        ball1.vx *= 0.95;
        ball1.vy *= 0.95;
    }
    return collides;
}


function detectWallCollision(ball, canvas) {
    var collides = false;
    if (ball.x - ball.r < 0 - ball.r || ball.x + ball.r > canvas.width + ball.r) {
      ball.vx = -ball.vx;
      collides = true;
    }
    return collides;
}
  