

$(document).ready(function(){


   if($('.smoke-container').length){



   class Smoke {

       constructor() {

           this._particles = [];

           this._particleCount = 10;

           this._maxVelocity = 0.8;

           //this._targetFPS = 60;

           this._imageObj = document.createElement('img');

           this._imageObj.src = 'images/smoke2.png';

           this._containerEl = document.querySelector('.smoke-container');

           this._canvasWidth = 1600;

           this._canvasHeight = 205;

           this._canvasContext = this._createContext(this._containerEl, this._canvasWidth, this._canvasHeight);



           this._initParticles();

       }



       _createContext(element, width, height) {

           var createHiDPICanvas = function(w, h) {

               var canvas = document.createElement('canvas');

               var context = canvas.getContext('2d');



               canvas.width = w;

               canvas.height = h;

               // canvas style width should be 100%

               canvas.style.width = `${w}px`;

               canvas.style.height = `${h}px`;

               return canvas;

           };



           var canvasElement = createHiDPICanvas(width, height);

           element.appendChild(canvasElement);



           return canvasElement.getContext('2d');

       }



       _initParticles() {

           for (var i = 0; i < this._particleCount; ++i) {

               var particle = new Particle(this._canvasContext);

               var randomPos = {

                   // x: this.generateRandom(this._canvasWidth / 3, this._canvasWidth * 2 / 3),

                   // y: this.generateRandom(this._canvasHeight / 3, this._canvasHeight * 2 / 3)
                   x: this.generateRandom(this._canvasWidth *2/ 3, this._canvasWidth  / 3),

                   y: this.generateRandom(this._canvasHeight , this._canvasHeight *2 / 3)

               };

               particle.setPosition(randomPos.x, randomPos.y);



               var randomVel = {

                   x: this.generateRandom(-this._maxVelocity, this._maxVelocity),

                   y: this.generateRandom(-this._maxVelocity, this._maxVelocity)

               };

               particle.setVelocity(randomVel.x, randomVel.y);



               particle.setImage(this._imageObj);

               this._particles.push(particle);

           }

       }






       generateRandom(min, max){

           //return Math.random() * (max - min) + min;

           return Math.random() * (max - min) + min;

       }



       draw() {

           this._canvasContext.clearRect(0, 0, this._canvasWidth, this._canvasHeight);



           this._particles.forEach(function(particle) {

               particle.draw();

           });

       }



       update() {

           this._particles.forEach(function(particle) {

               particle.update();

           });

       }

   }



   class Particle {

       constructor(context) {

           this._pos = { x: 0, y: 0 };

           this._vel = { x: 0, y: 0 };

           this._opacity = Math.random() * 0.5;

           this._deltaOpacity = Math.random() * 0.8 - 0.4;

           this._currentTime = 0;

           this._theta = 0.5;

           this._thetaRate = Math.random() * 0.002 - 0.001;

           this._context = context;



           this.updateCanvasSize();

       }



       updateCanvasSize() {

           this._canvasWidth = this._context.canvas.width;

           this._canvasHeight = this._context.canvas.height;



           this._canvasBoundary = {

               x: {

                   left: this._canvasWidth / 4,

                   right: (this._canvasWidth * 3) / 4

               },

               y: {

                   bottom: this._canvasHeight/3,

                   top: (this._canvasHeight * 2) / 3

               }

           };

       }



       draw() {

           if (this._image) {

               this._context.save();

               this._context.globalAlpha = this._opacity;

               this._context.translate(this._pos.x*0.8, this._image.height);

               this._context.rotate(this._theta);

               this._context.drawImage(this._image, -this._image.width / 2, -this._image.height);

               this._context.restore();

           }

       }



       update() {

           this._fadeCycle();

           this._theta += this._thetaRate;



           this._pos.x += this._vel.x;

           this._pos.y += this._vel.y;



           if (this._pos.x >= this._canvasBoundary.x.right) {

               this._vel.x = -this._vel.x;

               this._pos.x = this._canvasBoundary.x.right;

           } else if (this._pos.x <= this._canvasBoundary.x.left) {

               this._vel.x = -this._vel.x;

               this._pos.x = this._canvasBoundary.x.left;

           }



           if (this._pos.y >= this._canvasBoundary.y.top) {

               this._vel.y = -this._vel.y;

               this._pos.y = this._canvasBoundary.y.top;

           } else if (this._pos.y <= this._canvasBoundary.y.bottom) {

               this._vel.y = -this._vel.y;

               this._pos.y = this._canvasBoundary.y.bottom;

           }

       }



       _fadeCycle() {

           var angularFreq = Math.PI * 2 * this._deltaOpacity;

           this._opacity = Math.sin(this._currentTime * angularFreq);

           this._opacity = (this._opacity + 1) / 2;

           this._currentTime += 0.004;

       }



       setPosition(x, y) {

           this._pos.x = x;

           this._pos.y = y;

       }



       setVelocity(x, y) {

           this._vel.x = x;

           this._vel.y = y;

       }



       setImage(image) {

           this._image = image;

       }

   }





   var SmokeSystem = new Smoke();



   function animate() {

       SmokeSystem.update();

       SmokeSystem.draw();

       requestAnimationFrame(animate);

   }



   animate();

   };






   });
