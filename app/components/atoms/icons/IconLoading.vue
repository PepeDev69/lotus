<template>
	<div class="fxi-loading-dot">
		<div class="flex justify-center items-center relative">
			<div class="sk-chase">
				<div class="sk-chase-dot"></div>
				<div class="sk-chase-dot"></div>
				<div class="sk-chase-dot"></div>
				<div class="sk-chase-dot"></div>
				<div class="sk-chase-dot"></div>
				<div class="sk-chase-dot"></div>
			</div>
			<svg width="29" height="29" fill="none" viewBox="0 0 29 29" class="t-load">
				<circle cx="14.5" cy="14.5" r="14" stroke="#395D64" />
				<path
					fill="#395D64"
					d="M19.256 16.555c.145-.041.254-.062.353-.103.314-.126.423-.383.385-.694-.037-.303-.235-.486-.534-.544-.093-.017-.191-.007-.287-.005-1.489.03-2.301-.642-2.537-2.1-.112-.689-.302-.932-.718-.922-.399.01-.557.246-.656.926-.122.841-.645 1.368-1.394 1.685-.968.411-1.989.446-3.022.373-.217-.015-.435-.044-.652-.044a.589.589 0 0 0-.607.457c-.087.307-.01.602.287.737.256.117.275.283.276.514.003.684-.038 1.375.046 2.05.221 1.774 1.186 3.016 2.828 3.724.075.032.149.067.223.102-.54 1.08-1.98 1.623-3.3 1.25-1.135-.32-1.902-1.244-1.918-2.474-.03-2.393-.052-4.788.015-7.178.043-1.524.672-2.864 1.696-3.996.183-.202.221-.365.116-.612-.15-.352-.254-.721-.386-1.08-.132-.36-.049-.638.25-.87 3.27-2.545 7.088-2.118 9.986.012.303.223.378.522.224.87-.148.339-.31.672-.428 1.02-.04.12-.011.326.073.416 1.337 1.43 1.95 3.12 1.921 5.075-.03 2.024.01 4.049-.008 6.073-.019 2.235-2.245 3.567-4.209 2.506-.414-.224-.743-.607-1.166-.963l.413-.2c1.772-.852 2.681-2.26 2.729-4.226.013-.585 0-1.172 0-1.78Zm-5.26-6.917c.009.141.019.222.018.303-.006 1.043-.115.982 1.052.979.284 0 .43-.124.422-.422-.008-.279-.002-.558-.002-.843.15-.007.23-.014.311-.015 1.01-.01.981.197.969-1.054-.003-.27-.133-.403-.402-.402h-.863c-.006-.134-.014-.213-.014-.293.012-1.087.07-.962-1.051-.973-.29-.002-.429.124-.422.418.007.269 0 .539 0 .849-.328 0-.619-.036-.892.015-.143.027-.368.217-.363.32.02.369-.22.802.19 1.094.066.047.186.024.28.025h.767Z"
				/>
			</svg>
		</div>
		<h6 class="relative inline-flex items-center">
			<span class="pr-8">{{ text }}</span>
			<!-- <span class="dot-pulse"></span> -->
		</h6>
	</div>
</template>

<script>
export default {
	props: {
		text: {
			type: String,
			default: "Loading...",
		},
	},
};
</script>

<style lang="postcss">
.dot-pulse {
	position: relative;
	left: -9999px;
	width: 2px;
	height: 2px;
	border-radius: 50%;
	background-color: #395d64;
	color: #395d64;
	box-shadow: 9999px 0 0 -2px #395d64;
	animation: dotPulse 1.5s infinite linear;
	animation-delay: 0.25s;
}

.dot-pulse::before,
.dot-pulse::after {
	content: "";
	display: inline-block;
	position: absolute;
	bottom: -2px;
	width: 2px;
	height: 2px;
	border-radius: 50%;
	background-color: #395d64;
	color: #395d64;
}

.dot-pulse::before {
	box-shadow: 9984px 0 0 -2px #395d64;
	animation: dotPulseBefore 1.5s infinite linear;
	animation-delay: 0s;
}

.dot-pulse::after {
	box-shadow: 10006px 0 0 -2px #395d64;
	animation: dotPulseAfter 1.5s infinite linear;
	animation-delay: 0.5s;
}

@keyframes dotPulseBefore {
	0% {
		box-shadow: 9984px 0 0 -2px #395d64;
	}
	30% {
		box-shadow: 9984px 0 0 2px #395d64;
	}
	60%,
	100% {
		box-shadow: 9984px 0 0 -2px #395d64;
	}
}

@keyframes dotPulse {
	0% {
		box-shadow: 9994px 0 0 -2px #395d64;
	}
	30% {
		box-shadow: 9994px 0 0 2px #395d64;
	}
	60%,
	100% {
		box-shadow: 9994px 0 0 -2px #395d64;
	}
}

@keyframes dotPulseAfter {
	0% {
		box-shadow: 10006px 0 0 -2px #395d64;
	}
	30% {
		box-shadow: 10006px 0 0 2px #395d64;
	}
	60%,
	100% {
		box-shadow: 10006px 0 0 -2px #395d64;
	}
}
</style>
