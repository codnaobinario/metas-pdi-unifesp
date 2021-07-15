<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$valorInicial = 0.11;
$valores1 = [0.25, 0.48, 0.61, 0, 0];
$valores2 = [0, 0.68, 0.71, 0.88, 1];
$anoInicial = 2020;
$anos = [2021, 2022, 2003, 2024, 2025];
?>

<div class="grafico-linha" style="--color1: #A44B3A; --color2: #C4806E">
	<div class="grafico-box">
		<div class="divisoes">
			<div class="eixo-x">
				<div class="eixo-100">
					<span>100%</span>
				</div>
			</div>
			<div class="line"></div>
		</div>
		<div class="divisoes">
			<div class="eixo-x">
				<span>80%</span>
			</div>
			<div class="line"></div>
		</div>
		<div class="divisoes">
			<div class="eixo-x">
				<span>60%</span>
			</div>
			<div class="line"></div>
		</div>
		<div class="divisoes">
			<div class="eixo-x">
				<span>40%</span>
			</div>
			<div class="line"></div>
		</div>
		<div class="divisoes">
			<div class="eixo-x">
				<span>20%</span>
			</div>
			<div class="line border-bottom"></div>
		</div>
	</div>
	<div class="grafico-linha-views">
		<div></div>
		<div class="grafico-linha-statistcs">
			<?php for ($i = 0; $i < count($valores1); $i++) : ?>
				<?php
				if ($valores1[$i] == 0 || !$valores1[$i]) {
					$inicio = 0;
				} else {
					$inicio = ($i == 0) ? $valorInicial : $valores1[$i - 1];
				}
				?>
				<div class="divisoes" style="--start:<?php echo $inicio ?>; --end:<?php echo $valores1[$i] ?>;"></div>
			<?php endfor; ?>
		</div>
	</div>
	<div class="grafico-linha-views">
		<div></div>
		<div class="grafico-linha-statistcs2">
			<?php for ($i = 0; $i < count($valores2); $i++) : ?>
				<?php
				if ($valores2[$i] == 0 || !$valores2[$i]) {
					$inicio = 0;
				} else {
					$inicio = ($i == 0) ? $valorInicial : $valores2[$i - 1];
				}
				?>
				<div class="divisoes" style="--start:<?php echo $inicio ?>; --end:<?php echo ($inicio != 0) ? $valores2[$i] : 0 ?>;"></div>
			<?php endfor; ?>
		</div>
	</div>
	<div class="grafico-linha-views">
		<div></div>
		<div class="grafico-linha-pontos">
			<?php for ($i = 0; $i < count($valores1); $i++) : ?>
				<div class="divisoes">
					<?php if ($valores1[$i] != 0 && $valores1[$i]) : ?>
						<div class="ponto" style="--valor:<?php echo $valores1[$i] ?>;">
							<span><?php printf('%s%%', $valores1[$i] * 100) ?></span>
						</div>
					<?php endif; ?>
				</div>
			<?php endfor; ?>
		</div>
	</div>
	<div class="grafico-linha-views">
		<div></div>
		<div class="grafico-linha-pontos2">
			<?php for ($i = 0; $i < count($valores2); $i++) : ?>
				<div class="divisoes">
					<?php if ($valores2[$i] != 0 && $valores2[$i]) : ?>
						<div class="ponto" style="--valor:<?php echo $valores2[$i] ?>;">
							<span><?php printf('%s%%', $valores2[$i] * 100) ?></span>
						</div>
					<?php endif; ?>
				</div>
			<?php endfor; ?>
		</div>
	</div>
	<div class="grafico-linha-views">
		<div></div>
		<div class="grafico-linha-y">
			<?php for ($i = 0; $i < count($anos); $i++) : ?>
				<div class="divisoes">
					<?php if ($anos[$i] != 0 && $anos[$i]) : ?>
						<?php if ($i == 0) : ?>
							<div class="anoInit"><?php echo $anoInicial ?></div>
						<?php endif; ?>
						<div class="valor" style="--valor:<?php echo $anos[$i] ?>;">
							<span><?php echo $anos[$i] ?></span>
						</div>
					<?php endif; ?>
				</div>
			<?php endfor; ?>
		</div>
	</div>
</div>
<div class="grafico-linha-infos" style="--color1: #A44B3A; --color2: #C4806E">
	<div class="linha linha1">
		<div class="view"></div>
		<div class="label">Série Histórica</div>
	</div>
	<div class="linha linha2">
		<div class="view"></div>
		<div class="label">Metas Previstas</div>
	</div>
</div>