t1 <- Sys.time()

########### LIBRARY ############################################################
library(SpatialPosition)
library(RJSONIO)
library(rgdal)
library(classInt)

########### GET ACCESS IN INTERVAL - INTERNAL ##################################
GetAccess <- function(x, target, seqspans){
  if(target < min(x)){
    accTime <- seqspans[1]
  } else if(target > max(x)){
    accTime <- 99999999999999
  } else {
    minInterval <- max(which(x < target))
    maxInterval <- min(which(x > target))
    difMin <- target - x[minInterval]
    rangeInterval <- x[maxInterval] - x[minInterval]
    multFactor <- difMin / rangeInterval
    accTime <- seqspans[minInterval] + multFactor * (seqspans[maxInterval]
                                                     - seqspans[minInterval])
  }
  return(accTime)
}

######### IMPORT DES DONNEES ###################################################
importData <- function(input = input){
  # import the data file in a data.frame
  mydf <- read.csv(file.path(input, "dataset/data.csv"))
  # import the vectorial map file in a SpatialPolygonsDataFrame
  myspdf <- rgdal::readOGR(dsn = file.path(input, "map/"), layer = "map")
  myspdf@data$ID <- as.character(myspdf@data$ID)
  row.names(myspdf) <- myspdf$ID
  # merge data.frame and SpatialPolygonsDataFrame
  myspdf@data <- data.frame(myspdf@data, mydf[match( x = myspdf@data[,"ID"],
                                                     table = mydf[,"ID"]),
                                              2:dim(mydf)[2]])
  return(myspdf)
}

######### PREPARATION DES FOLDERS ##############################################
createFolders <- function(output){
  if (file.exists(file.path(output)) == F){
    dir.create(file.path(output))
  }
  if (file.exists(file.path(output,"map")) == F){
    dir.create(file.path(output,"map"))
  }
  if (file.exists(file.path(output,"data")) == F){
    dir.create(file.path(output,"data"))
  }
  if (file.exists(file.path(output,"json")) == F){
    dir.create(file.path(output,"json"))
  }
  if (file.exists(file.path(output,"graph")) == F){
    dir.create(file.path(output,"graph"))
  }
  if (file.exists(file.path(output,"nomenclature")) == F){
    dir.create(file.path(output,"nomenclature"))
  }
}

########## IMPORT DE MATRIX ####################################################
importMatrix <- function(matrixname, input = input, myspdf = myspdf){
  # import file
  mat <- read.csv(file = file.path(input,"matrix",matrixname),
                  check.names = FALSE, row.names = 1)
  # order matrix cols and rows according to myspdf IDs
  mat <- mat[myspdf@data$ID,myspdf@data$ID]
  return (mat)
}

########### IMPORT DES METADONNEES #############################################
# import the metatdata file
importMetaData <-function(input){
  mydfmetadata <- read.csv(file.path(input, "dataset/metadata.csv"),
                           stringsAsFactors = FALSE)
  return(mydfmetadata)
}

########### EXPORT NOMENCLATURE & CARTE #######################################
exportNomenclatureAndMap <- function(output = output, myspdf = myspdf){
  # nomenclature/nomenclature.csv
  write.table(myspdf@data[,1:2], file.path(output, "nomenclature",
                                           "nomenclature.csv"),
              sep =";", row.names=F, quote=F)
  # map/map.json
  myspdf@data <- myspdf@data[, 1:2]
  names(myspdf@data) <- c("id", "n")
  rgdal::writeOGR(obj = myspdf,
                  dsn = file.path(output, "map/map.json"), 
                  layer = "dataMap",check_exists = FALSE,
                  driver = "GeoJSON")
}

######## CREATION FICHIER POUR LES GRAPHS ######################################
createGraph <- function(output = output, myspdf = myspdf){
  for (k in 1:length(myspdf@data$ID)){
    write.table(x = c('"ID", "VAR", "MODE", "SPAN","VALUE"'),
                quote = F, sep = ",", dec = ".",
                append = FALSE, row.names = FALSE, col.names = F,
                file = file.path(output, "graph",
                                 paste(myspdf@data$ID[k], ".csv", sep = "")))
  }
}




################### CREATION DES FICHIERS ######################################
computeVal <- function(indParams = mydfmetadata, myspdf = myspdf,
                       mymat, dmode,
                       aParams, pParams, seqSpans)
{
  # data/data.csv, data/data.json, data/graph.csv
  pb <- txtProgressBar(min = 1, max = nrow(indParams), style=3)
  
  for (i in 1:nrow(indParams)){
    setTxtProgressBar(pb, i)
    myvar <- indParams$id[i]
    # sum of the stock variable and percent to reach (aParams)
    sumStock <- sum(myspdf@data[, myvar], na.rm = TRUE)
    pctStock <- aParams * sumStock
    potTab <- data.frame(matrix(nrow = nrow(myspdf@data)))
    row.names(potTab) <- myspdf@data$ID
    # compute potentials for sequence of spans
    potTab[,1] <- myspdf@data[, myvar]
    for (j in 2:length(seqSpans)){
      potTab[, j] <- stewart(knownpts = myspdf,
                             unknownpts = myspdf,
                             matdist = mymat,
                             beta = 3,
                             varname = myvar,
                             span = seqSpans[j])@data[, "OUTPUT"]
    }
    colnames(potTab) <- paste("SPAN", seqSpans, sep = "_")
    nbSpans <- length(seqSpans)
    for (k in 1:nrow(potTab)){
      mygraph <- data.frame(ID = rep(row.names(potTab)[k], nbSpans ),
                            VAR = rep(myvar, nbSpans),
                            MODE = rep(dmode, nbSpans),
                            SPAN = seqSpans, VALUE = as.vector(t(potTab[k,])))
      write.table(x = mygraph, append = TRUE,qmethod = "double", sep = ",",
                  dec = ".", col.names = FALSE,row.names = FALSE,
                  file = file.path(output, "graph",
                                   paste(row.names(potTab)[k], ".csv",
                                         sep = "")))
    }
    
    for (p in 1:length(pParams)){
      varName <- paste(myvar, dmode, "POT", pParams[p], sep = "_")
      potVal <- data.frame(ID = row.names(potTab),
                           VAR = potTab[,paste("SPAN",pParams[p], sep = "_" )],
                           stringsAsFactors = FALSE)
      potVal[is.na(potVal)] <- 99999999999999
      names(potVal)[2] <- varName
      
      potVal <- merge(myspdf@data[,1:2], potVal, by = "ID", all.x = TRUE)
      classfi <- classIntervals(var = potVal[,3], n = 9, style = "quantile")
      classfi <- data.frame(from = classfi$brks[-10], to  = classfi$brks[-1],
                            color = c("#F4BDC0",  "#ECA7AB",
                                      "#E59296", "#DE7C81",
                                      "#D56268",
                                      "#CB464C", "#BA2C33",
                                      "#8F1E21", "#64110F"))
      legendjson <-  vector("list", nrow(classfi))
      for (z in 1:nrow(classfi)){
        legendjson[[z]] <- list(from = classfi[z,1],
                                to = classfi[z,2],
                                color = as.character(classfi[z,3]))
      }
      json <- toJSON(legendjson)
      write(x = json,
            file = file.path(output,"data",paste(varName,"_legend.json",
                                                 sep="")))
      
      datajson <- vector("list", nrow(potVal))
      for (l in 1:nrow(potVal)){
        datajson[[l]] <- list(code = as.character(potVal[l,1]),
                              nom = as.character(potVal[l,2]),
                              value = potVal[l,3])
      }
      json <- toJSON(datajson)
      
      write(x = json,
            file = file.path(output,"data",paste(varName,".json",sep="")))
      write.csv(x = potVal,
                file = file.path(output,"data",paste(varName,".csv",sep="")),
                row.names=F)
    }
    
    # compute accessibility
    for(p in 1:length(pctStock)){
      varName <- paste(myvar, dmode, "ACC", aParams[p], sep = "_")
      accTemp <- apply(potTab, 1, GetAccess, target = pctStock[p],
                       seqspans = seqSpans)
      accVal <- data.frame(ID = names(accTemp), VAR = accTemp,
                           stringsAsFactors = FALSE)
      accVal[is.na(accVal)] <- 99999999999999
      names(accVal)[2] <- varName
      accVal <- merge(myspdf@data[,1:2], accVal, by = "ID", all.x = TRUE)
      # print(accVal)
      classfi <- classIntervals(var = accVal[,3], n = 9, style = "quantile")
      classfi <- data.frame(from = classfi$brks[-10], to  = classfi$brks[-1],
                            color = rev(c("#F4BDC0",  "#ECA7AB", "#E59296",
                                          "#DE7C81", "#D56268",
                                          "#CB464C", "#BA2C33", "#8F1E21",
                                          "#64110F")))
      legendjson <-  vector("list", nrow(classfi))
      for (z in 1:nrow(classfi)){
        legendjson[[z]] <- list(from = classfi[z,1],
                                to = classfi[z,2],
                                color = as.character(classfi[z,3]))
      }
      json <- toJSON(legendjson)
      write(x = json,
            file = file.path(output,"data",
                             paste(varName,"_legend.json",sep="")))
      datajson <- vector("list", nrow(accVal))
      for (m in 1:nrow(accVal)){
        datajson[[m]] <- list(code = as.character(accVal[m,1]),
                              nom = as.character(accVal[m,2]),
                              value = accVal[m,3])
      }
      json <- toJSON(datajson)
      write(x = json,
            file = file.path(output,"data",paste(varName,".json",sep="")))
      write.csv(accVal,file.path(output,"data",paste(varName,".csv",sep="")),
                row.names=F)
    }
  }
  close(pb)
}

######### CREATE PARAMS ########################################################
createParams <- function(output, mydfmetadata,
                         aParams = c(0.005, 0.01, 0.05),
                         matlist)
{
  Indicators <- vector("list", length = nrow(mydfmetadata))
  for (i in 1:nrow(mydfmetadata)){
    Indicators[[i]] <- list(id = mydfmetadata[i,"id"],
                            label = mydfmetadata[i,"label"],
                            units = mydfmetadata[i,"units"],
                            year = mydfmetadata[i,"year"])
  }
  Accessibility <- vector("list", length(aParams))
  for (i in 1:length(aParams)){
    Accessibility[[i]]<-list(id = paste("ACC",aParams[i],sep="_"),
                             label = paste(aParams[i]*100,"%",sep=" "))
  }
  Mode <- vector("list", length(matlist))
  for (i in 1:length(Mode)){
    Potential <- vector("list", length(matlist[[i]]$pParams))
    for (j in 1:length(matlist[[i]]$pParams)){
      Potential[[j]] <- list(id = paste("POT",matlist[[i]]$pParams[j],sep="_"),
                             label = paste(matlist[[i]]$pParams[j],
                                           matlist[[i]]$units,sep=" "))
    }
    Mode[[i]] <- list(id = matlist[[i]]$dmode,
                      label =matlist[[i]]$label,
                      order = matlist[[i]]$order,
                      potentials = list(Potential))
  }
  
  x <- list(noms = "params",
            Indicators = Indicators,
            Accessibility = Accessibility,
            Mode = Mode)
  # Transform to JSON
  json <- toJSON( x )
  # Export
  write(json,file.path(output,"json","params.json"))
}


# input and output folders
input <- "input_tun"
output <- "resources_tun"

createFolders(output = output)

myspdf <- importData(input = input)

mydfmetadata <- importMetaData(input = input)


mymat <- CreateDistMatrix(knownpts = myspdf, unknownpts = myspdf,
                          longlat = FALSE, bypassctrl = FALSE)

createGraph(output = output, myspdf = myspdf)

exportNomenclatureAndMap(output = output, myspdf = myspdf)

computeVal(indParams = mydfmetadata, myspdf = myspdf, mymat = mymat,
           dmode = "AsTheCrowFlies",
           aParams = c(0.005, 0.01, 0.05),
           pParams =  c(0,10000,20000,50000),
           seqSpans = c(0, seq(10000, 200000, 10000)))

x1 <- list(dmode = "AsTheCrowFlies", label = "Euclidean Distance",
           pParams =  c(0,10000,20000,50000), 
           order = 1,
           units = "meters")

createParams(output = output, mydfmetadata = mydfmetadata,
             aParams = c(0.005, 0.01, 0.05),
             matlist = list(x1))

Sys.time()-t1
