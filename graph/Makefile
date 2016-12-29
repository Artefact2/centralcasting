SOURCES=$(shell find ../data -type f -name "*.php")

graph.svgz: graph.svg
	gzip --force --best --keep $<
	mv $<.gz $@

graph.svg: graph.dot
	dot -Tsvg $< > $@

graph.dot: data.json gendot
	./gendot $< > $@

data.json: $(SOURCES) gendata
	./gendata > $@

clean:
	rm -f graph.dot graph.svg data.json

.PHONY: clean
