<template>
  <div class="containerMixer">
    <canvas class="mx-8" id="myCanvas" width="240" height="330"></canvas>
    <img id="mixerLogo" src="/images/mixer2.png" class="mixer mt-2" />
    <img id="becherLogo" src="/images/becher.png" class="mixer mt-2" />
    <div class="becherWrapper">
      <object
        id="liquidImage"
        type="image/svg+xml"
        data="/images/liquid.svg"
        class="inner-image"
      ></object>
    </div>
    <div class="becherWrapper">
      <object
        id="innerImage"
        type="image/svg+xml"
        data="/images/smoothie-juice.svg"
        class="inner-image"
      ></object>
    </div>
    <img id="mlZahlLogo" src="/images/mlzahl.png" class="mixer mt-2" />
  </div>
</template>

<script>
import gsap from "gsap";
export default {
  data() {
    return {
      canvas: null,
      ctx: null,
      fps: 1 / 60, //60 FPS
      timer: false,
      Cd: 0.47,
      rho: 1.22, //kg/m^3
      mouse: { x: 0, y: 0, isDown: false },
      ag: 9.81, //m/s^2 acceleration due to gravity on earth = 9.81 m/s^2.
      width: 0,
      height: 0,
      balls: [],
      mixAnimationBool: false,
      rgbList: [],
      sumColor: null,
      darkerRgbColor: null,
    };
  },
  mounted() {
    this.canvas = document.getElementById("myCanvas");
    this.ctx = this.canvas.getContext("2d");
    this.width = this.canvas.width;
    this.height = this.canvas.height;
    this.timer = setInterval(this.loop, 15);
    if (JSON.parse(sessionStorage.getItem("ingredientsArray"))) {
      this.balls = JSON.parse(sessionStorage.getItem("ingredientsArray"));
    }
    this.clearLiquid();
  },

  methods: {
    showAlertSuccess(title, text) {
      Swal.fire({
        title: title,
        text: text,
        icon: "success",
        showCancelButton: false,
        confirmButtonColor: "#6D9E1F",
        confirmButtonText: "Weiter!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$router.push({ path: `/` });
        }
      });
    },
    clearLiquid() {
      gsap.set("#innerImage, #liquidImage", {
        opacity: 0,
        y: "100%",
        transformOrigin: "bottom center",
      });
    },
    clearInterval() {
      this.ctx.clearRect(0, 0, this.width, this.height);
      sessionStorage.setItem("ingredientsArray", JSON.stringify(this.balls));
      clearInterval(this.timer);
    },
    getRGBList() {
      this.rgbList = [];
      Promise.all(
        this.balls.map((ball) => {
          return new Promise((resolve) => {
            const img = new Image();
            img.crossOrigin = "Anonymous";
            img.src = ball.img;
            img.onload = () => {
              const color = this.getMaxColor(img);
              this.rgbList.push(color);
              resolve(color);
            };
          });
        })
      ).then(() => {
        this.sumColor = this.getSumColor();
      });
    },
    getMaxColor(img) {
      const canvas = document.createElement("canvas");
      const context = canvas.getContext("2d");
      context.drawImage(img, 0, 0);
      const imageData = context.getImageData(0, 0, img.width, img.height);
      const pixels = imageData.data;
      const colorCounts = {};
      for (let i = 0; i < pixels.length; i += 4) {
        const r = pixels[i];
        const g = pixels[i + 1];
        const b = pixels[i + 2];

        // Check if the color is not black
        if (r + g + b > 0) {
          const rgb = `${r},${g},${b}`;
          if (rgb in colorCounts) {
            colorCounts[rgb] += 1;
          } else {
            colorCounts[rgb] = 1;
          }
        }
      }
      const maxCount = Math.max(...Object.values(colorCounts));
      const maxColor = Object.keys(colorCounts).find(
        (key) => colorCounts[key] === maxCount
      );
      return maxColor;
    },
    juice() {
      const tl = gsap.timeline();
      tl.play();
      tl.to("#innerImage", { duration: 1, rotate: -1 })
        .to("#innerImage", { duration: 4, rotate: 1 })
        .to("#innerImage", { duration: 1, rotate: 0 })
        .repeat(-1);
    },
    mixAnimation(amount) {
      clearInterval(this.timer);
      this.timer = setInterval(this.loop, 15);

      this.mixAnimationBool = true;
      const tl = gsap.timeline();

      this.juiceAnimation(amount);
      tl.play();
      tl.to(".containerMixer", { duration: 0.1, rotate: -1 })
        .to(".containerMixer", { duration: 0.1, rotate: 1 })
        .repeat(30)
        .eventCallback("onComplete", () => {
          gsap.to(".containerMixer", { duration: 0, rotate: 0 })
          this.clearInterval();
          this.juice();
         this.showAlertSuccess("Vielen Dank für deine Zusammenstellung!", "Klicke auf weiter um wieder zur Startseite zu gelangen!")
        });
    },
    liquidAnimation(image) {
      const img = new Image();
      img.crossOrigin = "Anonymous";
      img.src = "/images/piece/" + image;
      img.onload = () => {
        const svg = document.getElementById("liquidImage");
        let color = this.getMaxColor(img);
        const rgb = color.split(",").map(Number);
        svg.style.backgroundColor =
          "rgb(" + rgb[0] + "," + rgb[1] + "," + rgb[2] + ")";

        gsap.fromTo(
          "#liquidImage",
          { opacity: 0.8, y: "100%", transformOrigin: "bottom center" },
          { duration: 1, opacity: 0.8, y: "88%", ease: "power3.out" }
        );
      };
    },
    juiceAnimation(amount) {
      const amountInPercent = 87. - 2.6 * amount;
      this.getRGBList();
      const svg = document.getElementById("innerImage");
      const svgDoc = svg.contentDocument;
      const paths = svgDoc.getElementsByTagName("path");
      setTimeout(() => {
        svg.style.backgroundColor = this.sumColor;
        const rgbArray = this.sumColor.slice(4, -1).split(",").map(Number);
        const darkerRgbArray = rgbArray.map((val) => Math.round(val * 0.6));
        this.darkerRgbColor = `rgb(${darkerRgbArray.join(",")})`;
        for (let i = 0; i < paths.length; i++) {
          paths[i].style.fill = this.darkerRgbColor;
        }  
        gsap.fromTo(
          "#innerImage",
          { opacity: 1, y: "100%", transformOrigin: "bottom center" },
          { duration: 10, opacity: 1, y: amountInPercent+"%", ease: "power3.out" }
        );
      }, 300);
    },
    getSumColor() {
      const numColors = this.rgbList.length;
      // Initialisierung der Summenvariablen für die RGB-Werte
      let sumR = 0;
      let sumG = 0;
      let sumB = 0;

      // Schleife, um alle RGB-Werte der Farben zu addieren
      this.rgbList.forEach((color) => {
        const rgb = color.split(",").map(Number);
        sumR += rgb[0];
        sumG += rgb[1];
        sumB += rgb[2];
      });

      // Berechnung des Durchschnitts der RGB-Werte
      const avgR = Math.round(sumR / numColors);
      const avgG = Math.round(sumG / numColors);
      const avgB = Math.round(sumB / numColors);

      // Erstellung einer gemeinsamen Farbe
      const commonColor = `rgb(${avgR},${avgG},${avgB})`;
      return commonColor;
    },
    removeSpecificOne(image) {
      var count = 0;
      for (var i = 0; i < this.balls.length; i++) {
        if (this.balls[i].img === "/images/piece/" + image) {
          this.balls.splice(i, 1);
          count++;
          i--;
          if (count === 3) {
            break;
          }
        }
      }
      sessionStorage.setItem("ingredientsArray", JSON.stringify(this.balls));
    },
    removeSpecificAll(img) {
      this.balls = this.balls.filter(function (ball) {
        return ball.img !== "/images/piece/" + img;
      });
      sessionStorage.setItem("ingredientsArray", JSON.stringify(this.balls));
    },
    removeAll() {
      this.clearLiquid();
      this.balls = [];
      sessionStorage.setItem("ingredientsArray", JSON.stringify(this.balls));
    },
    setImg(image, count) {
      sessionStorage.setItem("ingredientsArray", JSON.stringify(this.balls));
      this.balls = JSON.parse(sessionStorage.getItem("ingredientsArray"));

      for (let i = 0; i < count * 3; i++) {
        this.balls.push(
          new Ball(Math.random() * (265 - 0) + 0, 50, 14, 0.7, 10, image)
        );
      }

      sessionStorage.setItem("ingredientsArray", JSON.stringify(this.balls));
      this.ingredientsArray = JSON.parse(
        sessionStorage.getItem("ingredientsArray")
      );
    },
    loop() {
      //create constants
      const gravity = 0.7;
      const density = 1;
      const drag = 1;
      //Clear window at the beginning of every frame
      this.ctx.clearRect(0, 0, this.width, this.height);
      for (let i = 0; i < this.balls.length; i++) {
        //physics - calculating the aerodynamic forces to drag
        // -0.5 * Cd * A * v^2 * rho
        let fx =
          -0.5 *
            drag *
            density *
            this.balls[i].area *
            this.balls[i].velocity.x *
            this.balls[i].velocity.x *
            (this.balls[i].velocity.x / Math.abs(this.balls[i].velocity.x)) ||
          0;
        let fy =
          -0.5 *
            drag *
            density *
            this.balls[i].area *
            this.balls[i].velocity.y *
            this.balls[i].velocity.y *
            (this.balls[i].velocity.y / Math.abs(this.balls[i].velocity.y)) ||
          0;

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

        const img = new Image();
        //Rendering the ball
        img.src = this.balls[i].img;
        this.ctx.beginPath();

        var angleInRadians = this.balls[i].rotation;
        var ballX = this.balls[i].position.x - this.balls[i].radius * 1.3;
        var ballY = this.balls[i].position.y - this.balls[i].radius * 1.3;
        var ballRadius = this.balls[i].radius;

        this.ctx.translate(ballX + ballRadius, ballY + ballRadius);

        this.ctx.rotate(angleInRadians);

        if (this.mixAnimationBool) {
          this.balls[i].rotation = angleInRadians + 0.5;
        }
        if (this.balls[i].velocity.y > 2) {
          this.balls[i].rotation =
            angleInRadians - this.balls[i].rotationDegree;
        }

        this.ctx.drawImage(img, -ballRadius, -ballRadius, 40, 40);

        this.ctx.rotate(-angleInRadians);
        this.ctx.translate(-(ballX + ballRadius), -(ballY + ballRadius));

        //this.ctx.arc(this.balls[i].position.x, this.balls[i].position.y, this.balls[i].radius, 0, 2 * Math.PI, true);
        //this.ctx.fill();
        this.ctx.closePath();

        //Handling the ball collisions

        this.collisionBall(this.balls[i]);
        this.collisionWall(this.balls[i]);
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
                colPointX + (b1.radius * (b1.position.x - b2.position.x)) / d;
              b1.position.y =
                colPointY + (b1.radius * (b1.position.y - b2.position.y)) / d;
              b2.position.x =
                colPointX + (b2.radius * (b2.position.x - b1.position.x)) / d;
              b2.position.y =
                colPointY + (b2.radius * (b2.position.y - b1.position.y)) / d;

              //updating velocity to reflect collision
              b1.velocity.x -= p * b1.mass * nx;
              b1.velocity.y -= p * b1.mass * ny;
              b2.velocity.x += p * b2.mass * nx;
              b2.velocity.y += p * b2.mass * ny;
            }
          }
        }
      }
    },
  },
};
class Ball {
  constructor(x, y, radius, e, mass, image) {
    this.position = { x: x, y: y }; //m
    this.velocity = { x: 0, y: 0 }; // m/s
    this.e = -e; // has no units
    this.mass = mass; //kg
    this.radius = radius; //m
    this.area = (Math.PI * radius * radius) / 100; //m^2
    this.img = "/images/piece/" + image;
    this.rotation = 0;
    this.rotationDegree =
      ((Math.floor(Math.random() * 11) - 5) * Math.PI) / 270;
  }
}
</script>


