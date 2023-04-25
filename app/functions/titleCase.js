"use strict";

const stopwords = "a an and at but by for in nor of on or so the to up yet".split(" ");

function capitalize(str) {
	return str.charAt(0).toUpperCase() + str.slice(1);
}

export const titleCase = (target, options = {}) => {
	if (!target) return "";
	const stop = options.stopwords || stopwords;
	const keep = options.keepSpaces;
	const splitter = /(\s+|[-‑–—])/;

	return target
		.split(splitter)
		.map((word, index, all) => {
			if (word.match(/\s+/)) return keep ? word : " ";
			if (word.match(splitter)) return word;
			if (index !== 0 && index !== all.length - 1 && stop.includes(word.toLowerCase())) {
				return word.toLowerCase();
			}
			return capitalize(word);
		})
		.join("");
};
