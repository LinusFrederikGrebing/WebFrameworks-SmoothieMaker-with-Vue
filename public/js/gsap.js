
gsap.fromTo(
    "#left-text",
    {
      scale: 0,
      opacity: 0,
      y: 200,
    },
    {
      y: 0,
      delay: 0.2,
      duration: 2,
      scale: 1,
      opacity: 1,
      ease: "power3.out",
    }
  );
  gsap.fromTo(
    "#right-img",
    {
      x: 500,
      scale: 0,
      opacity: 0,
    },
    {
      x: 0,
      delay: 0.2,
      duration: 2,
      scale: 1,
      opacity: 1,
      ease: "power3.out",
    }
  );

  gsap.timeline({ delay: 0, 
    scrollTrigger: {
    trigger: "#tips",
    start: "top 100%",
    end: "bottom 0%",
    toggleActions: "play reset play reset ",
  },})
  .fromTo("#tip1",  {
    delay: 0.5,
    y: 0,
    x: -1000,
    opacity: 0,
  },
  {
    opacity: 1,
    x: 0,
  })
  .fromTo("#tip2",  {
    y: 0,
    delay: 0.5,
    x: 1000,
    opacity: 0,
  },
  {
    opacity: 1,
    x: 0,
  })
  .fromTo("#tip3",  {
    delay: 0.5,
    y: 0,
    x: -1000,
    opacity: 0,
  },
  {
    opacity: 1,
    x: 0,
  });
