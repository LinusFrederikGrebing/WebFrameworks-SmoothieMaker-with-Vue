<template>
    <div class="containerMixer">
        <canvas class="mx-8" id="myCanvas" width="240" height="330"></canvas>
        <img id="mixerLogo" src="/images/mixer2.png" class="mixer mt-2">
        <img id="becherLogo" src="/images/becher.png" class="mixer mt-2">
        <img id="mlZahlLogo" src="/images/mlzahl.png" class="mixer mt-2">
    </div>
</template>

<script>
export default {
    data() {
        return {
            canvas: null,
            ctx: null,
            fps: 1 / 60, //60 FPS
            dt: this.fps * 100, //ms
            timer: false,
            Cd: 0.47,
            rho: 1.22, //kg/m^3
            mouse: { x: 0, y: 0, isDown: false },
            ag: 9.81, //m/s^2 acceleration due to gravity on earth = 9.81 m/s^2.
            width: 0,
            height: 0,
            balls: [],
        };
    },
    mounted() {
        this.canvas = document.getElementById("myCanvas");
        this.ctx = this.canvas.getContext("2d");
        this.width = this.canvas.width;
        this.height = this.canvas.height;
        this.timer = setInterval(this.loop, this.dt);
        if (JSON.parse(sessionStorage.getItem("zutatenArray"))) {
            this.balls = JSON.parse(sessionStorage.getItem("zutatenArray"));
        }
    },
    methods: {
        clearInterval(){
            clearInterval(this.timer);
        },
        removeSpecificOne(image) {
            var count = 0;
            for (var i = 0; i < this.balls.length; i++) {
                if (this.balls[i].img === "../images/" + image) {
                    this.balls.splice(i, 1);
                    count++;
                    i--;
                    if (count === 1) {
                        break;
                    }
                }
            }
            sessionStorage.setItem("zutatenArray", JSON.stringify(this.balls));
        },
        removeSpecificAll(img) {
            this.balls = this.balls.filter(function (ball) {
                return ball.img !== "../images/" + img;
            });
            sessionStorage.setItem("zutatenArray", JSON.stringify(this.balls));
        },
        removeAll() {
            this.balls = [];
            sessionStorage.setItem("zutatenArray", JSON.stringify(this.balls));
        },
        setImg(image, count) {
            if (JSON.parse(sessionStorage.getItem("zutatenArray"))) {
            this.balls = JSON.parse(sessionStorage.getItem("zutatenArray"));
            }
            for (let i = 0; i < count * 2; i++) {
                this.balls.push(new Ball(Math.random() * (265 - 0) + 0, 50, 18, 0.7, 10, image));
            }
        
            sessionStorage.setItem("zutatenArray", JSON.stringify(this.balls));
            this.zutatenArray = JSON.parse(sessionStorage.getItem("zutatenArray"));
        },
        loop() {
            //create constants
            const gravity = 0.7;
            const density = 1;
            const drag = 1;
           
            //Clear window at the beginning of every frame
            this.ctx.clearRect(0, 0, this.width, this.height);
            for (let i = 0; i < this.balls.length; i++) {
                if (!this.mouse.isDown || i != this.balls.length - 1) {
                    //physics - calculating the aerodynamic forces to drag
                    // -0.5 * Cd * A * v^2 * rho
                    let fx =
                        (-0.5 *
                            drag *
                            density *
                            this.balls[i].area *
                            this.balls[i].velocity.x *
                            this.balls[i].velocity.x *
                            (this.balls[i].velocity.x / Math.abs(this.balls[i].velocity.x))) || 0;
                    let fy =
                        (-0.5 *
                            drag *
                            density *
                            this.balls[i].area *
                            this.balls[i].velocity.y *
                            this.balls[i].velocity.y *
                            (this.balls[i].velocity.y / Math.abs(this.balls[i].velocity.y))) || 0;

                    //Calculating the acceleration of the ball
                    //F = ma or a = F/m
                    let ax = fx / this.balls[i].mass;
                    let ay = this.ag * gravity + fy / this.balls[i].mass;

                    //Calculating the ball velocity
                    this.balls[i].velocity.x += ax * this.fps;
                    this.balls[i].velocity.y += ay * this.fps;

                    //Calculating the position of the ball
                    this.balls[i].position.x += this.balls[i].velocity.x * this.fps * 100;
                    this.balls[i].position.y += this.balls[i].velocity.y * this.fps * 100;
                }
                const img = new Image();
                //Rendering the ball
                img.src = this.balls[i].img;
                this.ctx.beginPath();

                this.ctx.drawImage(
                    img,
                    this.balls[i].position.x - this.balls[i].radius * 1.7,
                    this.balls[i].position.y - this.balls[i].radius * 1.8,
                    60,
                    60
                );
                //this.ctx.arc(this.balls[i].position.x, this.balls[i].position.y, this.balls[i].radius, 0, 2 * Math.PI, true);
                //this.ctx.fill();
                this.ctx.closePath();

                //Handling the ball collisions
                this.collisionBall(this.balls[i]);
                this.collisionWall(this.balls[i]);
            
                sessionStorage.setItem("zutatenArray", JSON.stringify(this.balls));
            }
        },
        collisionWall(ball) {
            if (ball.position.x > this.width - ball.radius) {
                ball.velocity.x *= ball.e;
                ball.position.x = this.width - ball.radius;
            }
            if (ball.position.y > this.height - ball.radius) {
                ball.velocity.y *= ball.e;
                ball.position.y = this.height - ball.radius;
            }
            if (ball.position.x < ball.radius) {
                ball.velocity.x *= ball.e;
                ball.position.x = ball.radius;
            }
            if (ball.position.y < ball.radius) {
                ball.velocity.y *= ball.e;
                ball.position.y = ball.radius;
            }
        },
        collisionBall(b1) {
            for (let i = 0; i < this.balls.length; i++) {
                const b2 = this.balls[i];
                if (b1.position.x != b2.position.x && b1.position.y != b2.position.y) {
                    //quick check for potential collisions using AABBs
                    if (
                        b1.position.x + b1.radius + b2.radius > b2.position.x &&
                        b1.position.x < b2.position.x + b1.radius + b2.radius &&
                        b1.position.y + b1.radius + b2.radius > b2.position.y &&
                        b1.position.y < b2.position.y + b1.radius + b2.radius
                    ) {
                        //pythagoras
                        const distX = b1.position.x - b2.position.x;
                        const distY = b1.position.y - b2.position.y;
                        const d = Math.sqrt(distX * distX + distY * distY);

                        //checking circle vs circle collision
                        if (d < b1.radius + b2.radius) {
                            const nx = (b2.position.x - b1.position.x) / d;
                            const ny = (b2.position.y - b1.position.y) / d;
                            const p =
                                (2 *
                                    (b1.velocity.x * nx +
                                        b1.velocity.y * ny -
                                        b2.velocity.x * nx -
                                        b2.velocity.y * ny)) /
                                (b1.mass + b2.mass);

                            // calulating the point of collision
                            const colPointX =
                                (b1.position.x * b2.radius + b2.position.x * b1.radius) /
                                (b1.radius + b2.radius);
                            const colPointY =
                                (b1.position.y * b2.radius + b2.position.y * b1.radius) /
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
    }
}
class Ball {
    constructor(x, y, radius, e, mass, image) {
        this.position = { x: x, y: y }; //m
        this.velocity = { x: 0, y: 0 }; // m/s
        this.e = -e; // has no units
        this.mass = mass; //kg
        this.radius = radius; //m
        this.area = (Math.PI * radius * radius) / 100; //m^2
        this.img = "/images/" + image;
    }
}
</script>


