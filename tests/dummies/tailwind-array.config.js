const palettes = require('./tailwind.palettes')

module.exports = {
    theme: {
        extend: {
            colors: {
                accent: palettes['hot-cinnamon'],
            },
        },
    },
};
