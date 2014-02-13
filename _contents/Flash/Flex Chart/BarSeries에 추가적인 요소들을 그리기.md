---
primary: efa79d1545

---

# BarSeries의 그리는 시점 잡아내기

		override protected function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void
		{
			super.updateDisplayList(unscaledWidth, unscaledHeight);

			// loop code copied from BarSeries
			var barSeriesItems:Array=renderData.filteredCache;
			var rect:Rectangle;
			var f:int, fmax:int;

			if (transitionRenderData && transitionRenderData.elementBounds) {
				var elementBounds:Array=transitionRenderData.elementBounds;

				f=-1;
				fmax=barSeriesItems.length;
				while (++f < fmax) {
					rect=elementBounds[f];
					// draw(f, rect, v);
				}
			}
			else {
				var bo:Number=renderData.renderedHalfWidth + renderData.renderedYOffset;
				var to:Number=-renderData.renderedHalfWidth + renderData.renderedYOffset;

				rect=new Rectangle();

				f=-1;
				fmax=barSeriesItems.length;
				while (++f < fmax) {
					var v:BarSeriesItem=barSeriesItems[f];

					rect.top=v.y + to;
					rect.bottom=v.y + bo;
					rect.right=v.x;
					if (!isNaN(v.min)) {
						rect.left=v.min;
					}
					else {
						rect.left=renderData.renderedBase;
					}

					// draw(f, rect, v);
				}
			}
		}

`BarSeries`에서 복사해서 정리한 코드이다. 위와 같이 